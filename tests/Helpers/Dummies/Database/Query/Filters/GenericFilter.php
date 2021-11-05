<?php

namespace Aedart\Tests\Helpers\Dummies\Database\Query\Filters;

use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Database\Query\FieldFilter;

/**
 * Generic Filter
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Database\Query\Filters
 */
class GenericFilter extends FieldFilter
{
    /**
     * @inheritDoc
     */
    public function apply($query)
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhere($this->field(), $this->operator(), $this->value());
        }

        return $query->where($this->field(), $this->operator(), $this->value());
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function allowedOperators(): array
    {
        return [
            '=',
            '!=',
            '>',
            '<'
        ];
    }
}
