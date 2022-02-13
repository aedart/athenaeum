<?php

namespace Aedart\Filters\Query\Filters\Fields;

use DateTimeInterface;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * Datetime Filter
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
class DatetimeFilter extends DateFilter
{
    /**
     * State whether given datetime must be converted
     * to UTC or not
     *
     * @var bool
     */
    protected bool $utc = false;

    /**
     * @inheritDoc
     */
    public function apply(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        $operator = $this->operator();

        return match ($operator) {
            'is_null' => $this->buildWhereNullConstraint($query),
            'not_null' => $this->buildWhereNotNullConstraint($query),
            default => $this->buildWhereDatetimeConstraint($query, $this->utc)
        };
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Returns list of allowed date formats
     *
     * @return string[]
     */
    protected function allowedDateFormats(): array
    {
        return [
            // In case that you are having trouble validating a full RFC3339,
            // E.g. "2021-06-17T06:33:00+00:00", then remember that dates
            // should be URL encoded, when used submitted via http query parameters.
            // "+00:00" will then become "%2B00:00". Thus, "2021-06-17T06:33:00%2B00:00"
            // should pass the RFC3339 format validation.
            DateTimeInterface::RFC3339,
            'Y-m-d H:i:s',
            'Y-m-d H:i',
            'Y-m-d',
        ];
    }
}
