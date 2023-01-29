<?php

namespace Aedart\Filters\Query\Filters\Fields;

use Aedart\Contracts\Utils\Dates\DateTimeFormats;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * Datetime Filter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
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
            default => $this->buildWhereDatetimeConstraint($query, $this->mustConvertToUtc())
        };
    }

    /**
     * Set whether datetime must be converted to UTC or not
     *
     * @param bool $convert
     *
     * @return self
     */
    public function convertToUtc(bool $convert = false): static
    {
        $this->utc = $convert;

        return $this;
    }

    /**
     * Determine if datetime must be converted to UTC
     *
     * @return bool
     */
    public function mustConvertToUtc(): bool
    {
        return $this->utc;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function defaultAllowedFormats(): array
    {
        return [
            // In case that you are having trouble validating a full RFC3339,
            // E.g. "2021-06-17T06:33:00+00:00", then remember that dates
            // should be URL encoded, when used submitted via http query parameters.
            // "+00:00" will then become "%2B00:00". Thus, "2021-06-17T06:33:00%2B00:00"
            // should pass the RFC3339 format validation.
            DateTimeFormats::RFC3339_EXTENDED_ZULU,
            DateTimeFormats::RFC3339_ZULU,
            'Y-m-d H:i:s',
            'Y-m-d H:i',
            'Y-m-d',
        ];
    }
}
