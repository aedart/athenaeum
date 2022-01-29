<?php

namespace Aedart\Filters\Query\Filters\Fields;

use Aedart\Utils\Str;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use InvalidArgumentException;

/**
 * Numeric Filter
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
class NumericFilter extends BaseFieldFilter
{
    /**
     * @inheritDoc
     */
    public function apply(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        $operator = $this->operator();

        return match ($operator) {
            'in' => $this->buildWhereInConstraint($query),
            'not_in' => $this->buildWhereNotInConstraint($query),
            'is_null' => $this->buildWhereNullConstraint($query),
            'not_null' => $this->buildWhereNotNullConstraint($query),
            default => $this->buildDefaultConstraint($query),
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
            'in' => 'in',
            'not_in' => 'not_in',
        ];
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
        $operator = $this->operator();
        if (empty($value) && in_array($operator, [ 'is_null', 'not_null' ])) {
            return;
        }

        // Allow list of numeric values...
        if (in_array($operator, [ 'in', 'not_in' ]) && Str::contains($value, ',')) {
            $values = $this->valueToList($value);

            foreach ($values as $v) {
                $this->assertNumericValue($v);
            }

            return;
        }

        $this->assertNumericValue($value);
    }

    /**
     * Assert given value is numeric
     *
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    protected function assertNumericValue(mixed $value)
    {
        if (!is_numeric($value)) {
            $translator = $this->getTranslator();

            throw new InvalidArgumentException($translator->get('validation.numeric', [ 'attribute' => 'value' ]));
        }
    }
}
