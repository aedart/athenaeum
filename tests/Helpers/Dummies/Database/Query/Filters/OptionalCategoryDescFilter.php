<?php

namespace Aedart\Tests\Helpers\Dummies\Database\Query\Filters;

use Aedart\Database\Query\Filter;

class OptionalCategoryDescFilter extends Filter
{
    /**
     * Search term that category description should
     * contain
     *
     * @var string
     */
    protected string $search;

    /**
     * State whether filter should be applied or not
     *
     * @var bool
     */
    protected bool $shouldApplyFilter;

    /**
     * @param string $search
     * @param bool $apply [optional]
     */
    public function __construct(string $search, bool $apply = true)
    {
        $this->search = $search;
        $this->shouldApplyFilter = $apply;
    }

    /**
     * @inheritDoc
     */
    public function isApplicable($query = null, $filters = []): bool
    {
        return $this->shouldApplyFilter;
    }


    /**
     * @inheritDoc
     */
    public function apply($query)
    {
        return $query->where('description', 'LIKE', "%{$this->search}%");
    }
}
