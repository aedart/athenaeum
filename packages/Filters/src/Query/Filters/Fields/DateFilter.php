<?php

namespace Aedart\Filters\Query\Filters\Fields;

use Aedart\Utils\Arr;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use InvalidArgumentException;

/**
 * Date Filter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
class DateFilter extends BaseFieldFilter
{
    /**
     * List of allowed date / datetime formats
     *
     * @var string[]
     */
    protected array $allowedFormats = [];

    /**
     * @inheritDoc
     */
    public function apply(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        $operator = $this->operator();

        return match ($operator) {
            'is_null' => $this->buildWhereNullConstraint($query),
            'not_null' => $this->buildWhereNotNullConstraint($query),
            default => $this->buildWhereDateConstraint($query)
        };
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

    /**
     * Set list of allowed date / datetime formats
     *
     * @param string|string[] $formats
     *
     * @return self
     */
    public function setAllowedDateFormats(string|array $formats): static
    {
        if (is_string($formats)) {
            $formats = [ $formats ];
        }

        $this->allowedFormats = $formats;

        return $this;
    }

    /**
     * Returns list of allowed date / datetime formats
     *
     * @return string[]
     */
    public function allowedDateFormats(): array
    {
        if (empty($this->allowedFormats)) {
            $this->setAllowedDateFormats($this->defaultAllowedFormats());
        }

        return $this->allowedFormats;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function assertValue(mixed $value)
    {
        // Allow empty values, when "is null / not null" operators are
        // chosen.
        if (empty($value) && in_array($this->operator(), [ 'is_null', 'not_null' ])) {
            return;
        }

        $field = $this->field();

        // To ensure that the submitted date is valid, we will rely on Laravel's validator.
        // It's by far the simplest way of ensuring the input is as desired. Note the
        // array-undot call. This is done in case of evt. table name prefixes, then we must
        // ensure that the "data" is associative, or the applied validation rule might fail.
        $validator = $this->getValidatorFactory()->make(Arr::undot([ $field => $value ]), [
            $field => 'required|date_format:' . implode(',', $this->allowedDateFormats())
        ]);

        if ($validator->fails()) {
            $reason = $validator->errors()->first($field);
            throw new InvalidArgumentException($reason);
        }
    }

    /**
     * Returns default allowed date / datetime formats
     *
     * @return string[]
     */
    protected function defaultAllowedFormats(): array
    {
        return [
            'Y-m-d',
        ];
    }
}
