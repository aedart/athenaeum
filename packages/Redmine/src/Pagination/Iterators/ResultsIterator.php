<?php

namespace Aedart\Redmine\Pagination\Iterators;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\ApiResource;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Contracts\Redmine\Iterators\ResultsIterator as ResultsIteratorInterface;
use Aedart\Contracts\Redmine\PaginatedResults;
use JsonException;
use Throwable;

/**
 * Results Iterator
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Pagination\Iterators
 */
class ResultsIterator implements ResultsIteratorInterface
{
    /**
     * The API Resource that must perform pagination
     *
     * @var ApiResource
     */
    protected ApiResource $resource;

    /**
     * The request builder
     *
     * @var Builder
     */
    protected Builder $request;

    /**
     * The "pool" size - maximum limit of results to fetch
     * per request
     *
     * @var int
     */
    protected int $size;

    /**
     * The current results set
     *
     * @var PaginatedResults
     */
    protected PaginatedResults $resultsSet;

    /**
     * Current iterator position, in current results set
     *
     * @var int
     */
    protected int $relativePosition = 0;

    /**
     * The absolute position if the iterator, across
     * all available results
     *
     * @var int
     */
    protected int $absolutePosition = 0;

    /**
     * ResultsIterator
     *
     * @param ApiResource $resource
     * @param Builder $request
     * @param int $size [optional] The "pool" size - maximum limit of results to fetch per request
     */
    public function __construct(ApiResource $resource, Builder $request, int $size = 10)
    {
        $this->resource = $resource;
        $this->request = $request;
        $this->size = $size;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        $this->rewindIfRequired();

        // Return from current results set
        return $this->resultsSet
            ->results()
            ->get($this->relativePosition);
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $resultsSet = $this->resultsSet;

        // Compute next relative position...
        $nextRelativePosition = $this->relativePosition + 1;

        // When the next relative position does not exist, yet there are more results to be
        // fetched, perform the next request.
        if (!$resultsSet->results()->has($nextRelativePosition) && $resultsSet->hasNextPage()) {
            // Paginate to next results - relative position will be reset to zero!
            $this->paginate($resultsSet->nextPageOffset());

            // Increase the absolute position
            $this->absolutePosition++;

            // Stop further processing
            return;
        }

        // Increase the relative position - even if this might cause in null to be
        // returned by the current() method - can happen if next is invoked several
        // times, long after there are no more results. Such would be a violation
        // of the iterator capabilities, yet the interface does not state that
        // it's an illegal act.
        $this->relativePosition = $nextRelativePosition;

        // Lastly, we also increase the absolute position - even if this will cause
        // an invalid position. The valid method must ensure to check for this.
        $this->absolutePosition++;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->absolutePosition;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        $this->rewindIfRequired();

        return $this->absolutePosition < $this->resultsSet->total();
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        // Skip rewind, if we already are at the first results set.
        if (isset($this->resultsSet) && $this->resultsSet->currentPage() === $this->resultsSet->firstPage()) {
            return;
        }

        // Fetch results for the first page
        $this->paginate(0);

        // Reset the absolute position
        $this->absolutePosition = 0;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        $this->rewindIfRequired();

        return $this->resultsSet->total();
    }

    /**
     * The API Resource in question
     *
     * @return ApiResource
     */
    public function resource(): ApiResource
    {
        return $this->resource;
    }

    /**
     * The request builder used by this iterator
     *
     * @return Builder
     */
    public function request(): Builder
    {
        return $this->request;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Rewind - fetch first results, but only if no previous results
     * have been obtained.
     *
     * @return self
     */
    protected function rewindIfRequired(): self
    {
        if (!isset($this->resultsSet)) {
            $this->rewind();
        }

        return $this;
    }

    /**
     * Fetch results at given offset
     *
     * @param int $offset [optional]
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    protected function paginate(int $offset = 0)
    {
        // Fetch "new" results
        $this->resultsSet = $this
            ->resource()
            ->paginate(
                $this->request(),
                $this->size,
                $offset
            );

        // Reset the relative position
        $this->relativePosition = 0;
    }
}
