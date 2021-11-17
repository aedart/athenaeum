<?php

namespace Aedart\Filters\Query\Filters\Fields;

use Aedart\Utils\Str;
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
    public function apply($query)
    {
        $operator = $this->operator();

        switch ($operator) {
            case 'in':
                return $this->buildWhereInConstraint($query);

            case 'not_in':
                return $this->buildWhereNotInConstraint($query);

            case 'is_null':
                return $this->buildWhereNullConstraint($query);

            case 'not_null':
                return $this->buildWhereNotNullConstraint($query);

            default:
                return $this->buildDefaultConstraint($query);
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
    protected function assertValue($value)
    {
        // Allow list of numeric values...
        if (Str::contains($value, ',')) {
            $values = $this->valueToList($value);

            foreach ($values as $v) {
                $this->assertValue($v);
            }

            return;
        }

        if (!is_numeric($value)) {
            $translator = $this->getTranslator();

            throw new InvalidArgumentException($translator->get('validation.numeric', [ 'attribute' => 'value' ]));
        }
    }
}
