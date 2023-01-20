<?php

namespace Aedart\Filters\Query\Filters\Fields;

use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Database\Query\FieldFilter;
use Aedart\Filters\Query\Filters\Concerns;
use Aedart\Support\Helpers\Translation\TranslatorTrait;
use Aedart\Support\Helpers\Validation\ValidatorFactoryTrait;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * Base Field Filter
 *
 * Abstraction offers common filter functionality
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
abstract class BaseFieldFilter extends FieldFilter
{
    use ValidatorFactoryTrait;
    use TranslatorTrait;
    use Concerns\DatabaseDriver;

    /**
     * The datetime format used by the database
     *
     * @var string
     */
    protected string $datetimeFormat = 'Y-m-d H:i:s';

    /**
     * Map of operators (aliases) and corresponding database
     * sql operator.
     *
     * @return array Key-value pair, key = operator submitted in http query parameters,
     *               value = sql operator or other kind token that determines how
     *               filter must build it query.
     */
    abstract public function operatorAliases(): array;

    /**
     * @inheritDoc
     */
    public function setOperator(string $operator): static
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
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildDefaultConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhere($this->field(), $this->operator(), $this->value());
        }

        return $query->where($this->field(), $this->operator(), $this->value());
    }

    /**
     * Builds "where [field] IS NULL" constraint
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereNullConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereNull($this->field());
        }

        return $query->whereNull($this->field());
    }

    /**
     * Builds "where [field] NOT NULL" constraint
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereNotNullConstraint(Builder|EloquentBuilder $query)
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereNotNull($this->field());
        }

        return $query->whereNotNull($this->field());
    }

    /**
     * Builds "where [field] IN [...]" constraint
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereInConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
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
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereNotInConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
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
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereContainsConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        $value = "%{$this->value()}%";

        return $this->buildWhereLike($query, $value);
    }

    /**
     * Builds "where [field] NOT LIKE %xxxx%" constraint
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereNotContainsConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        $value = "%{$this->value()}%";

        return $this->buildWhereNotLike($query, $value);
    }

    /**
     * Builds "where [field] LIKE xxxx%" constraint
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereStartsWithConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        $value = "{$this->value()}%";

        return $this->buildWhereLike($query, $value);
    }

    /**
     * Builds "where [field] NOT LIKE xxxx%" constraint
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereNotStartsWithConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        $value = "{$this->value()}%";

        return $this->buildWhereNotLike($query, $value);
    }

    /**
     * Builds "where [field] LIKE %xxxx" constraint
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereEndsWithConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        $value = "%{$this->value()}";

        return $this->buildWhereLike($query, $value);
    }

    /**
     * Builds "where [field] NOT LIKE %xxxx" constraint
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereNotEndsWithConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        $value = "%{$this->value()}";

        return $this->buildWhereNotLike($query, $value);
    }

    /**
     * Builds "where [field] [operator] [datetime value]" constraint
     *
     * @param Builder|EloquentBuilder $query
     * @param bool $utc  [optional]
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereDatetimeConstraint(Builder|EloquentBuilder $query, bool $utc = false): Builder|EloquentBuilder
    {
        $field = $this->field();
        $operator = $this->operator();

        // Parse date and convert to UTC, if required.
        $date = Carbon::parse($this->value());
        if ($utc) {
            $date = $date->utc();
        }

        // If equals or not equals operators are chosen, then we need to build
        // a range search for the given date, with a -/+ seconds offset, due
        // to the database's datetime precision. IF not, then chances are that
        // a submitted datetime can never be matched precisely, especially if
        // seconds precision required.
        if (in_array($operator, ['=', '!='])) {
            // Operators to be used for range comparison
            $low = '>=';
            $high = '<=';

            if ($operator === '!=') {
                $low = '<';
                $high = '>';
            }

            // Callback that builds the actual datetime comparison, with a -/+ seconds offset...
            $dateComparisonCallback = function ($query) use ($date, $low, $high) {
                return $this->datetimeRangeComparison($query, $date, $low, $high);
            };

            if ($this->logical() === FieldCriteria::OR) {
                return $query->orWhere($dateComparisonCallback);
            }

            return $query->where($dateComparisonCallback);
        }

        // Otherwise, for regular comparisons operators (<,>, <=, and >=)
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhere($field, $operator, $date->format($this->datetimeFormat));
        }

        return $query->where($field, $operator, $date->format($this->datetimeFormat));
    }

    /**
     * Returns a datetime range comparison
     *
     * @param Builder|EloquentBuilder $query
     * @param Carbon $date
     * @param string $low [optional] Low end datetime comparison operator
     * @param string $high [optional] High end datetime comparison operator
     * @param int $offset [optional] Evt. -/+ seconds offset. If date has zero second
     *                     then this offset will be multiplied with 60, to match a full
     *                     minute...
     *
     * @return Builder|EloquentBuilder
     */
    protected function datetimeRangeComparison(
        Builder|EloquentBuilder $query,
        Carbon $date,
        string $low = '>=',
        string $high = '<=',
        int $offset = 1
    ): Builder|EloquentBuilder {
        // The general database datetime format to use.
        $format = $this->datetimeFormat;

        // In case that no "seconds" precision is given, then ensure
        // that we increase the offset and adapt the format. This should
        // give a more acceptable result, rather than having "equals / not equals"
        // fail finding anything...
        if ($date->second === 0) {
            $format = 'Y-m-d H:i:00';
            $offset *= 60; // Seconds
        }

        $field = $this->getField();

        return $query
            ->where($field, $low, $date->format($format))
            ->where($field, $high, $date->addSeconds($offset)->format($format));
    }

    /**
     * Builds "where [field] [operator] [date value]" constraint
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereDateConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhereDate($this->field(), $this->operator(), $this->value());
        }

        return $query->whereDate($this->field(), $this->operator(), $this->value());
    }

    /**
     * Builds "where [field] LIKE [value]" constraint
     *
     * @param Builder|EloquentBuilder $query
     * @param string $value
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereLike(Builder|EloquentBuilder $query, string $value): Builder|EloquentBuilder
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
     * @param Builder|EloquentBuilder $query
     * @param string $value
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildWhereNotLike(Builder|EloquentBuilder $query, string $value): Builder|EloquentBuilder
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
     * @param Builder|EloquentBuilder $query
     *
     * @return string
     */
    protected function resolveLikeOperator(Builder|EloquentBuilder $query): string
    {
        $driver = $this->determineDriver($query);

        return match ($driver) {
            // Use the case-insensitive "ilike" operator, so that...
            // @see https://github.com/postgres/postgres/blob/master/src/backend/utils/adt/like.c
            'pgsql' => 'ilike',
            default => 'like'
        };
    }

    /**
     * Resolves the "not like" operator to be used, for the given query's
     * database connection driver
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return string
     */
    protected function resolveNotLikeOperator(Builder|EloquentBuilder $query): string
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
    protected function convertToBoolean(mixed $value): bool
    {
        return (int) filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
