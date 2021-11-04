<?php

namespace Aedart\Tests\Helpers\Dummies\Database\Query\Filters;

use Aedart\Database\Query\Filter;

/**
 * Products Category Filter
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
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
    public function apply($query)
    {
        return $query->where('name', $this->name);
    }
}
