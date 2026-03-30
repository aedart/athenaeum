<?php

namespace Aedart\Filters\Query\Filters\Fields;

use Aedart\Database\Query\FieldFilter;
use Aedart\Filters\Query\Filters\Concerns;
use Aedart\Support\Helpers\Translation\TranslatorTrait;
use Aedart\Support\Helpers\Validation\ValidatorFactoryTrait;
use Aedart\Utils\Dates\Precision;
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
     * @var string|null
     */
    protected string|null $databaseDatetimeFormat = null;

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

    /**
     * Set the datetime format used for queries
     *
     * @param string|null $format
     *
     * @return self
     */
    public function setDatabaseDatetimeFormat(string|null $format): static
    {
        $this->databaseDatetimeFormat = $format;

        return $this;
    }

    /**
     * Get the datetime format used for queries
     *
     * @return string|null
     */
    public function getDatabaseDatetimeFormat(): string|null
    {
        if (!isset($this->databaseDatetimeFormat)) {
            $this->setDatabaseDatetimeFormat($this->getDefaultDatabaseDatetimeFormat());
        }

        return $this->databaseDatetimeFormat;
    }

    /**
     * Returns a default datetime format to be used in queries
     *
     * @return string
     */
    public function getDefaultDatabaseDatetimeFormat(): string
    {
        return 'Y-m-d H:i:s';
    }

    /**
     * Resolves the datetime format to be used
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return string
     */
    public function resolveDatetimeFormat(Builder|EloquentBuilder $query): string
    {
        if (!isset($this->databaseDatetimeFormat) && $query instanceof EloquentBuilder) {
            $format = $query->getModel()->getDateFormat();

            $this->setDatabaseDatetimeFormat($format);
        }

        return $this->getDatabaseDatetimeFormat();
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
     * operator is a native supported SQL operator.
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildDefaultConstraint(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        return $this->buildFor(
            and: fn () => $query->where($this->field(), $this->operator(), $this->value()),
            or: fn () => $query->orWhere($this->field(), $this->operator(), $this->value())
        );
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
        return $this->buildFor(
            and: fn () => $query->whereNull($this->field()),
            or: fn () => $query->orWhereNull($this->field())
        );
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
        return $this->buildFor(
            and: fn () => $query->whereNotNull($this->field()),
            or: fn () => $query->orWhereNotNull($this->field())
        );
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

        return $this->buildFor(
            and: fn () => $query->whereIn($this->field(), $value),
            or: fn () => $query->orWhereIn($this->field(), $value)
        );
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

        return $this->buildFor(
            and: fn () => $query->whereNotIn($this->field(), $value),
            or: fn () => $query->orWhereNotIn($this->field(), $value)
        );
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
     * @param bool $utc  [optional] Converts datetime value to UTC if true
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

        // Resolve an offset for "high" (inclusive) ranges.
        $precision = Precision::Second;
        $offset = ($date->second === 0)
            ? 59 // Seconds
            : 0;

        // Check if millisecond precision is supported by model, and adjust offset.
        if ($offset === 0
            && $query instanceof EloquentBuilder
            && str_ends_with($query->getModel()->getDateFormat(), '.v')
        ) {
            $precision = Precision::Millisecond;
            $offset = ($date->millisecond === 0)
                ? 999 // Milliseconds
                : 0;
        }

        // If equals or not equals operators are chosen, then we need to build
        // a range search for the given datetime.
        if (in_array($operator, ['=', '!=']) && $offset !== 0) {
            // Callback that builds the actual datetime comparison, with a -/+ seconds offset...
            $dateComparisonCallback = function (Builder|EloquentBuilder $query) use ($date, $operator, $offset, $precision) {
                $low = $this->makeLowDate($date, $precision);
                $high = $this->makeHighDate($date, $offset, $precision);

                if ($operator === '=') {
                    return $this->buildDatetimeBetween($query, $low, $high);
                }

                return $this->buildDatetimeNotBetween($query, $low, $high);
            };

            return $this->buildFor(
                and: fn () => $query->where($dateComparisonCallback),
                or: fn () => $query->orWhere($dateComparisonCallback)
            );
        }

        $format = $this->resolveDatetimeFormat($query);

        return $this->buildFor(
            and: fn () => $query->where($field, $operator, $date->format($format)),
            or: fn () => $query->orWhere($field, $operator, $date->format($format))
        );
    }

    /**
     * Builds "where [field] between [datetime a, datetime b]" constraint
     *
     * @param Builder|EloquentBuilder $query
     * @param Carbon $low
     * @param Carbon $high
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildDatetimeBetween(Builder|EloquentBuilder $query, Carbon $low, Carbon $high): Builder|EloquentBuilder
    {
        $field = $this->getField();
        $format = $this->resolveDatetimeFormat($query);

        return $query->whereBetween($field, [ $low->format($format), $high->format($format) ]);
    }

    /**
     * Builds "where [field] not between [datetime a, datetime b]" constraint
     *
     * @param Builder|EloquentBuilder $query
     * @param Carbon $low
     * @param Carbon $high
     *
     * @return Builder|EloquentBuilder
     */
    protected function buildDatetimeNotBetween(Builder|EloquentBuilder $query, Carbon $low, Carbon $high): Builder|EloquentBuilder
    {
        $field = $this->getField();
        $format = $this->resolveDatetimeFormat($query);

        return $query->whereNotBetween($field, [ $low->format($format), $high->format($format) ]);
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
        return $this->buildFor(
            and: fn () => $query->whereDate($this->field(), $this->operator(), $this->value()),
            or: fn () => $query->orWhereDate($this->field(), $this->operator(), $this->value())
        );
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

        return $this->buildFor(
            and: fn () => $query->where($this->field(), $like, $value),
            or: fn () => $query->orWhere($this->field(), $like, $value)
        );
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

        return $this->buildFor(
            and: fn () => $query->where($this->field(), $like, $value),
            or: fn () => $query->orWhere($this->field(), $like, $value)
        );
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

    /**
     * Creates a "low" range date
     *
     * @param Carbon $date
     * @param Precision $precision [optional] Supports second and millisecond
     *
     * @return Carbon
     */
    protected function makeLowDate(Carbon $date, Precision $precision = Precision::Second): Carbon
    {
        return match ($precision) {
            Precision::Second => Carbon::make($date)->setSecond(0),
            Precision::Millisecond => Carbon::make($date)->setMillisecond(0),
            default => Carbon::make($date)
        };
    }

    /**
     * Creates a "high" range date
     *
     * @param Carbon $date
     * @param int $offset
     * @param Precision $precision [optional] Supports second and millisecond
     *
     * @return Carbon
     */
    protected function makeHighDate(Carbon $date, int $offset, Precision $precision = Precision::Second): Carbon
    {
        return match ($precision) {
            Precision::Second => Carbon::make($date)->setSecond(0)->addSeconds($offset),
            Precision::Millisecond => Carbon::make($date)->setMillisecond(0)->addMilliseconds($offset),
            default => Carbon::make($date)
        };
    }
}
