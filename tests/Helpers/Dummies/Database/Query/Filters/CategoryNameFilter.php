<?php

namespace Aedart\Tests\Helpers\Dummies\Database\Query\Filters;

use Aedart\Database\Query\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * Products Category Filter
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Database\Query\Filters
 */
class CategoryNameFilter extends Filter
{
    /**
     * Name of category to be filtered
     *
     * @var string
     */
    protected string $name;

    /**
     * CategoryNameFilter
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function apply(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        return $query->where('name', $this->name);
    }
}
