<?php

namespace Aedart\Redmine\Pagination;

use Aedart\Contracts\Redmine\PaginatedResults as PaginatedResultsInterface;
use Aedart\Contracts\Redmine\Resource;
use Aedart\Pagination\Paginator;
use Aedart\Redmine\Collections\Collection;
use Aedart\Redmine\RedmineResource;
use Aedart\Utils\Json;
use Illuminate\Support\Enumerable;
use JsonException;
use Psr\Http\Message\ResponseInterface;

/**
 * Paginated Results
 *
 * @see \Aedart\Contracts\Redmine\PaginatedResults
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Pagination
 */
class PaginatedResults extends Paginator implements PaginatedResultsInterface
{
    /**
     * Results collection
     *
     * @var Collection<RedmineResource>
     */
    protected Collection $results;

    /**
     * PaginatedResults
     *
     * @param Collection<RedmineResource> $results
     * @param int $total [optional] Total amount of results
     * @param int $limit [optional] The results limit
     * @param int $offset [optional] Results offset
     */
    public function __construct(
        Collection $results,
        int $total = 0,
        int $limit = 10,
        int $offset = 0
    ) {
        parent::__construct($total, $limit, $offset);

        $this->results = $results;
    }

    /**
     * @inheritdoc
     */
    public static function fromResponse(ResponseInterface $response, Resource $resource): PaginatedResultsInterface
    {
        // Decode entire payload - we do not need to determine between single or multiple
        // resources here.
        $payload = $resource->decode($response);

        // Extract list (found results)
        $results = Collection::fromResponsePayload($payload, $resource);

        // Extract pagination details
        $total = $resource->extractOrDefault('total_count', $payload, count($results));
        $limit = $resource->extractOrDefault('limit', $payload, count($results));
        $offset = $resource->extractOrDefault('offset', $payload, 0);

        return new static($results, $total, $limit, $offset);
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return $this->results->getIterator();
    }

    /**
     * {@inheritDoc}
     *
     * @return Collection<RedmineResource>
     */
    public function results(): Enumerable
    {
        return $this->results;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'results' => $this->results()->toArray(),
            'total' => $this->total(),
            'limit' => $this->limit(),
            'offset' => $this->offset(),
            'per_page' => $this->perPage(),
            'total_pages' => $this->lastPage(),
            'page' => $this->currentPage(),
            'first_page' => $this->firstPage(),
            'last_page' => $this->lastPage(),
            'previous_page' => $this->previousPage(),
            'next_page' => $this->nextPage()
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @throws JsonException
     */
    public function toJson($options = 0)
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Returns a string representation of this Data Transfer Object
     *
     * @return string
     *
     * @throws JsonException
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Debug info
     *
     * @return array
     */
    public function __debugInfo(): array
    {
        return $this->toArray();
    }
}
