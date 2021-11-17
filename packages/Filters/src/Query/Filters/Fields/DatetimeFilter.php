<?php

namespace Aedart\Filters\Query\Filters\Fields;

use DateTimeInterface;
use InvalidArgumentException;

/**
 * Datetime Filter
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
class DatetimeFilter extends BaseFieldFilter
{
    /**
     * @inheritDoc
     */
    public function apply($query)
    {
        $operator = $this->operator();

        switch ($operator) {
            case 'is_null':
                return $this->buildWhereNullConstraint($query);

            case 'not_null':
                return $this->buildWhereNotNullConstraint($query);

            default:
                return $this->buildWhereDateConstraint($query);
        }
    }

    /**
     * @inheritDoc
     */
    public function operatorAliases(): array
    {
        return [
            'eq' => '=',
            'ne' => '!=',
            'gt' => '>',
            'gte' => '>=',
            'lt' => '<',
            'lte' => '<=',

            // NOTE: Values do NOT correspond directly to sql operators for these...
            'is_null' => 'is_null',
            'not_null' => 'not_null',
        ];
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function assertValue($value)
    {
        // Allow empty values, when "is null / not null" operators are
        // chosen.
        if (empty($value) && in_array($this->operator(), [ 'is_null', 'not_null' ])) {
            return;
        }

        $field = $this->field();

        // To ensure that the submitted date is valid, we
        // will rely on Laravel's validator - it's by far the
        // simplest way of ensuring the input is as desired.
        $validator = $this->getValidatorFactory()->make([ $field => $value ], [
            $field => 'required|date_format:' . implode(',', $this->allowedDateFormats())
        ]);

        if ($validator->fails()) {
            $reason = $validator->errors()->first($field);
            throw new InvalidArgumentException($reason);
        }
    }

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
