<?php

namespace Aedart\Tests\Helpers\Dummies\Database\Query\Filters;

use Aedart\Database\Query\FieldFilter;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * Generic Filter
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Database\Query\Filters
 */
class GenericFilter extends FieldFilter
{
    /**
     * @inheritDoc
     */
    public function apply(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        return $this->buildFor(
            and: fn () => $query->where($this->field(), $this->operator(), $this->value()),
            or: fn () => $query->orWhere($this->field(), $this->operator(), $this->value())
        );
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
