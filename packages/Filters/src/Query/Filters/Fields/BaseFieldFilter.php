<?php

namespace Aedart\Filters\Query\Filters\Fields;

use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Database\Query\FieldFilter;
use Aedart\Filters\Query\Filters\Concerns;
use Aedart\Support\Helpers\Validation\ValidatorFactoryTrait;

/**
 * Base Field Filter
 *
 * Abstraction offers common filter functionality
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
abstract class BaseFieldFilter extends FieldFilter
{
    use ValidatorFactoryTrait;
    use Concerns\DatabaseDriver;

    /**
     * Map of operators (aliases) and corresponding database
     * sql operator.
     *
     * @return array Key-value pair, key = operator alias, value = sql operator or
     *               other kind token that determines how filter must build it
     *               query.
     */
    abstract public function operatorAliases(): array;

    /**
     * @inheritDoc
     */
    public function setOperator(string $operator)
    {
        // Assert if "alias" is allowed
        $this->assertOperator($operator, $this->allowedOperators());

        $this->operator = $this->operatorAliases()[$operator];

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function allowedOperators(): array
    {
        // Use the aliases as "allowed" operators
        return array_keys($this->operatorAliases());
    }

    /**
     * Builds a default "where [field] [operator] [value]" constraint
     *
     * Caution: This is the most generic where clause build method. It assumes that assigned
     * operator is a native supported sql operator.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildDefaultConstraint($query)
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhere($this->field(), $this->operator(), $this->value());
        }

        return $query->where($this->field(), $this->operator(), $this->value());
    }

    /**
     * Builds "where [field] IS NULL" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereNullConstraint($query)
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereNull($this->field());
        }

        return $query->whereNull($this->field());
    }

    /**
     * Builds "where [field] NOT NULL" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereNotNullConstraint($query)
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereNotNull($this->field());
        }

        return $query->whereNotNull($this->field());
    }

    /**
     * Builds "where [field] IN [...]" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereInConstraint($query)
    {
        $value = $this->valueToList($this->value());

        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereIn($this->field(), $value);
        }

        return $query->whereIn($this->field(), $value);
    }

    /**
     * Builds "where [field] NOT IN [...]" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereNotInConstraint($query)
    {
        $value = $this->valueToList($this->value());

        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereNotIn($this->field(), $value);
        }

        return $query->whereNotIn($this->field(), $value);
    }

    /**
     * Builds "where [field] LIKE %xxxx%" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereContainsConstraint($query)
    {
        $value = "%{$this->value()}%";

        return $this->buildWhereLike($query, $value);
    }

    /**
     * Builds "where [field] NOT LIKE %xxxx%" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereNotContainsConstraint($query)
    {
        $value = "%{$this->value()}%";

        return $this->buildWhereNotLike($query, $value);
    }

    /**
     * Builds "where [field] LIKE xxxx%" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereStartsWithConstraint($query)
    {
        $value = "{$this->value()}%";

        return $this->buildWhereLike($query, $value);
    }

    /**
     * Builds "where [field] NOT LIKE xxxx%" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereNotStartsWithConstraint($query)
    {
        $value = "{$this->value()}%";

        return $this->buildWhereNotLike($query, $value);
    }

    /**
     * Builds "where [field] LIKE %xxxx" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereEndsWithConstraint($query)
    {
        $value = "%{$this->value()}";

        return $this->buildWhereLike($query, $value);
    }

    /**
     * Builds "where [field] NOT LIKE %xxxx" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereNotEndsWithConstraint($query)
    {
        $value = "%{$this->value()}";

        return $this->buildWhereNotLike($query, $value);
    }

    /**
     * Builds "where [field] [operator] [date / datetime value]" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereDateConstraint($query)
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereDate($this->field(), $this->operator(), $this->value());
        }

        return $query->whereDate($this->field(), $this->operator(), $this->value());
    }

    /**
     * Builds "where [field] LIKE [value]" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     * @param string $value
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereLike($query, string $value)
    {
        $like = $this->resolveLikeOperator($query);

        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhere($this->field(), $like, $value);
        }

        return $query->where($this->field(), $like, $value);
    }

    /**
     * Builds "where [field] NOT LIKE [value]" constraint
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     * @param string $value
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    protected function buildWhereNotLike($query, string $value)
    {
        $like = $this->resolveNotLikeOperator($query);

        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhere($this->field(), $like, $value);
        }

        return $query->where($this->field(), $like, $value);
    }

    /**
     * Resolves the "like" operator to be used, for the given
     * query's database connection driver
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return string
     */
    protected function resolveLikeOperator($query): string
    {
        $driver = $this->determineDriver($query);

        switch ($driver) {
            // Use the case-insensitive "ilike" operator, so that...
            // @see https://github.com/postgres/postgres/blob/master/src/backend/utils/adt/like.c
            case 'pgsql':
                return 'ilike';

            default:
                return 'like';
        }
    }

    /**
     * Resolves the "not like" operator to be used, for the given query's
     * database connection driver
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return string
     */
    protected function resolveNotLikeOperator($query): string
    {
        $like = $this->resolveLikeOperator($query);

        return "not {$like}";
    }

    /**
     * Convert given value to a list of values
     *
     * @param string $value
     * @param string $delimiter [optional]
     *
     * @return array
     */
    protected function valueToList(string $value, string $delimiter = ','): array
    {
        return array_map(function ($item) {
            return trim($item);
        }, explode($delimiter, $value));
    }

    /**
     * Converts value to boolean
     *
     * @see filter_var
     * @see FILTER_VALIDATE_BOOLEAN
     *
     * @param mixed $value
     *
     * @return bool
     */
    protected function convertToBoolean($value): bool
    {
        return (int) filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}