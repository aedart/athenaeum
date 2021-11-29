<?php

namespace Aedart\Filters\Query\Filters;

use Aedart\Database\Query\Filter;

/**
 * Search Filter
 *
 * A search filter that attempts to match given search term against
 * one or many table columns.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Query\Filters
 */
class SearchFilter extends Filter
{
    use Concerns\DatabaseDriver;
    use Concerns\StopWords;

    /**
     * Full search string
     *
     * @var string
     */
    protected string $search;

    /**
     * List of columns to search
     *
     * @var string[]
     */
    protected array $columns;

    /**
     * Language to be used
     *
     * @var string
     */
    protected string $language = 'en';

    /**
     * SearchFilter
     *
     * @param string $search
     * @param string[] $columns
     * @param string $language [optional]
     */
    public function __construct(string $search, array $columns, string $language = 'en')
    {
        $this->search = $search;
        $this->columns = $columns;
        $this->language = $language;
    }

    /**
     * @inheritDoc
     */
    public function apply($query)
    {
        return $query->where(function ($query) {
            /** @var \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query */

            // Remove evt. stop words from search term(s). However,
            // in case that nothing is returned, then we must abort the
            // search.
            $search = $this->removeStopWords($this->search, $this->language);
            if (mb_strlen($search) === 0) {
                return;
            }

            // Built a search query for the entire search term, matching
            // all the specified columns as "or where" constraints.
            $this->searchFor($search, $query);
        });
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Builds a sub-query that matches given search term against
     * specified columns
     *
     * @param string $searchTerm
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function searchFor(string $searchTerm, $query)
    {
        foreach ($this->columns as $column) {
            $query = $this->matchColumn($column, $searchTerm, $query);
        }

        return $query;
    }

    /**
     * Builds query that matches against given search term, for the given column
     *
     * @param string $column
     * @param string $search
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function matchColumn(string $column, string $search, $query)
    {
        return $query
            ->orWhere(function ($query) use ($column, $search) {
                /** @var \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query */

                $driver = $this->determineDriver($query);
                switch ($driver) {
                    case 'pgsql':
                        return $this->buildPsqlWhereLike($column, $search, $query);

                    default:
                        return $this->buildDefaultWhereLike($column, $search, $query);
                }
            });
    }

    /**
     * Builds "or where column ..." clause, for postgresql database connection driver
     *
     * @param string $column
     * @param string $search
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildPsqlWhereLike(string $column, string $search, $query)
    {
        // Sadly Postgres' way of performing "simple" case-insensitive searches, is
        // via a none-standard "ilike" operator. Alternatives are available, yet
        // they are much more cumbersome and very driver specific.
        // Other databases support setting the collation / ctype and thus offer
        // case-insensitive string as an implicit operations, e.g. via like operator.
        // Postgres also offers this, but FAILS for "like" operator (I do not know why!)
        // @see https://github.com/postgres/postgres/blob/master/src/backend/utils/adt/like.c
        return $query
            ->orWhere($column, 'ilike', "{$search}")
            ->orWhere($column, 'ilike', "{$search}%")
            ->orWhere($column, 'ilike', "%{$search}%");
    }

    /**
     * Builds "or where column ..." clause, for default database connection driver
     *
     * @param string $column
     * @param string $search
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildDefaultWhereLike(string $column, string $search, $query)
    {
        return $query
            ->orWhere($column, 'like', "{$search}")
            ->orWhere($column, 'like', "{$search}%")
            ->orWhere($column, 'like', "%{$search}%");
    }
}
