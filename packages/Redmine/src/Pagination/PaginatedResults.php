<?php

namespace Aedart\Redmine\Pagination;

use Aedart\Contracts\Redmine\ApiResource;
use Aedart\Contracts\Redmine\PaginatedResults as PaginatedResultsInterface;
use Aedart\Pagination\Paginator;
use Aedart\Redmine\Collections\Collection;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Utils\Json;
use Illuminate\Support\Enumerable;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Traversable;

/**
 * Paginated Results
 *
 * @see \Aedart\Contracts\Redmine\PaginatedResults
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Pagination
 */
class PaginatedResults extends Paginator implements PaginatedResultsInterface
{
    /**
     * Results collection
     *
     * @var Collection<RedmineApiResource>
     */
    protected Collection $results;

    /**
     * PaginatedResults
     *
     * @param Collection<RedmineApiResource> $results
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
    public static function fromResponse(ResponseInterface $response, ApiResource $resource): static
    {
        // Decode entire payload - we do not need to determine between single or multiple
        // resources here.
        $payload = $resource->decode($response);

        // Extract list (found results)
        $results = Collection::fromResponsePayload($payload, $resource);
        $amountResults = count($results);

        // Extract pagination details
        $total = $resource->extractOrDefault('total_count', $payload, $amountResults);
        $limit = $resource->extractOrDefault('limit', $payload, $amountResults);
        $offset = $resource->extractOrDefault('offset', $payload, 0);

        if ($limit < 1 && $amountResults === 0) {
            $limit = 1;
        }

        return new static($results, $total, $limit, $offset);
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return $this->results->getIterator();
    }

    /**
     * {@inheritDoc}
     *
     * @return Collection<RedmineApiResource>
     */
    public function results(): Enumerable
    {
        return $this->results;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
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
    public function toJson($options = 0): string
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
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
    public function __toString(): string
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
