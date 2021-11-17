<?php

namespace Aedart\Filters\Query\Filters\Fields;

use InvalidArgumentException;

/**
 * Boolean Filter
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
class BooleanFilter extends BaseFieldFilter
{
    /**
     * @inheritDoc
     */
    public function apply($query)
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
    public function setValue($value)
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
