<?php

namespace Aedart\Tests\Helpers\Dummies\Database\Query\Filters;

use Aedart\Database\Query\Filter;

/**
 * Category Slug Filter
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Database\Query\Filters
 */
class CategorySlugFilter extends Filter
{
    /**
     * Slug identifier
     *
     * @var string
     */
    protected string $slug;

    /**
     * CategorySlugFilter
     *
     * @param string $slug
     */
    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @inheritDoc
     */
    public function apply($query)
    {
        return $query->where('slug', $this->slug);
    }
}
