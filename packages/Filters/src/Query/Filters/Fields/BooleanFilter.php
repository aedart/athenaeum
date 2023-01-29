<?php

namespace Aedart\Filters\Query\Filters\Fields;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use InvalidArgumentException;

/**
 * Boolean Filter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
class BooleanFilter extends BaseFieldFilter
{
    /**
     * @inheritDoc
     */
    public function apply(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        return $this->buildDefaultConstraint($query);
    }

    /**
     * @inheritDoc
     */
    public function operatorAliases(): array
    {
        return [
            'eq' => '=',
            'ne' => '!=',
        ];
    }

    /**
     * @inheritDoc
     */
    public function setValue(mixed $value): static
    {
        $this->assertValue($value);

        $this->value = $this->convertToBoolean($value);

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function assertValue($value)
    {
        $acceptable = ['yes', 'no', 'true', 'false', true, false, 0, 1, '0', '1'];

        if (!in_array($value, $acceptable)) {
            $translator = $this->getTranslator();

            throw new InvalidArgumentException($translator->get('validation.boolean', [ 'attribute' => $this->field() ]));
        }
    }
}
