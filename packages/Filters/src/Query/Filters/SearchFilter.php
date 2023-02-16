<?php

namespace Aedart\Filters\Query\Filters;

use Aedart\Database\Query\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * Search Filter
 *
 * A search filter that attempts to match given search term against
 * one or many table columns.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query\Filters
 */
class SearchFilter extends Filter
{
    use Concerns\DatabaseDriver;

    /**
     * Full search string
     *
     * @var string
     */
    protected string $search;

    /**
     * List of columns to be matched or callbacks to apply
     *
     * @var string[]|callable[]
     */
    protected array $columns;

    /**
     * SearchFilter
     *
     * @param string $search
     * @param string|callable|string[]|callable[] $columns
     */
    public function __construct(string $search, string|callable|array $columns)
    {
        if (!is_array($columns)) {
            $columns = [ $columns ];
        }

        $this->search = $search;
        $this->columns = $columns;
    }

    /**
     * @inheritDoc
     */
    public function apply(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        return $query->where(function (Builder|EloquentBuilder $query) {
            $search = trim($this->search);
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
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function searchFor(string $searchTerm, Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        foreach ($this->columns as $column) {
            if (!is_string($column) && is_callable($column)) {
                $query = $this->applySearchCallback($column, $query, $searchTerm);
                continue;
            }

            $query = $this->matchColumn($column, $searchTerm, $query);
        }

        return $query;
    }

    /**
     * Applies search callback for given search term
     *
     * @param callable $callback
     * @param Builder|EloquentBuilder $query
     * @param string $searchTerm
     *
     * @return Builder|EloquentBuilder
     */
    protected function applySearchCallback(callable $callback, Builder|EloquentBuilder $query, string $searchTerm): Builder|EloquentBuilder
    {
        return $callback($query, $searchTerm);
    }

    /**
     * Builds query that matches against given search term, for the given column
     *
     * @param string $column
     * @param string $search
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function matchColumn(string $column, string $search, Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        return $query
            ->orWhere(function (Builder|EloquentBuilder $query) use ($column, $search) {
                $driver = $this->determineDriver($query);

                return match ($driver) {
                    'psql' => $this->buildPsqlWhereLike($column, $search, $query),
                    default => $this->buildDefaultWhereLike($column, $search, $query)
                };
            });
    }

    /**
     * Builds "or where column ..." clause, for postgresql database connection driver
     *
     * @param string $column
     * @param string $search
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildPsqlWhereLike(string $column, string $search, Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        return $query
            ->orWhere($column, 'ilike', "{$search}%")
            ->orWhere($column, 'ilike', "%{$search}%");
    }

    /**
     * Builds "or where column ..." clause, for default database connection driver
     *
     * @param string $column
     * @param string $search
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildDefaultWhereLike(string $column, string $search, Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        return $query
            ->orWhere($column, 'like', "{$search}%")
            ->orWhere($column, 'like', "%{$search}%");
    }
}
