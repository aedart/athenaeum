<?php

namespace Aedart\Redmine\Pagination;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\ApiResource;
use Aedart\Contracts\Redmine\TraversableResults as TraversableResultsInterface;
use Aedart\Redmine\Pagination\Iterators\ResultsIterator;

/**
 * Traversable Results
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Pagination
 */
class TraversableResults implements TraversableResultsInterface
{
    /**
     * The results iterator
     *
     * @var ResultsIterator<ApiResource>
     */
    protected ResultsIterator $iterator;

    /**
     * TraversableResults
     *
     * @param ApiResource $resource
     * @param Builder $request
     * @param int $size [optional]
     */
    public function __construct(ApiResource $resource, Builder $request, int $size = 10)
    {
        $this->iterator = new ResultsIterator($resource, $request, $size);
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return $this->iterator;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->iterator->count();
    }
}
