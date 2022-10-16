<?php

namespace Aedart\Http\Api\Resources;

use Aedart\Http\Api\Responses\PaginatedApiResourceResponse;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

/**
 * Api Resource Collection
 *
 * Specialised abstraction of Laravel's `ResourceCollection`
 *
 * @see ResourceCollection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources
 */
abstract class ApiResourceCollection extends ResourceCollection
{
    /**
     * Indicates if all existing request query parameters should be added to pagination links.
     *
     * @var bool
     */
    protected $preserveAllQueryParameters = true;

    /**
     * The paginated API resource response class to use
     *
     * @var string
     */
    protected string $paginatedResponseClass = PaginatedApiResourceResponse::class;

    /**
     * Creates a new Api Resource Collection instance
     *
     * @param  mixed  $resource
     * @param  string  $collects Class path to Api Resource
     */
    public function __construct(mixed $resource, string $collects)
    {
        $this->collects = $collects;

        parent::__construct($resource);
    }

    /**
     * Invoke a callback over each resource
     *
     * @param  callable  $callback
     *
     * @return self
     */
    public function each(callable $callback): static
    {
        $this->collection->each($callback);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        // Ensure that each resource in the collection outputs its meta-data.
        return $this->collection->transform(function ($resource) use ($request) {
            return array_merge($resource->jsonSerialize(), $resource->with($request));
        });
    }

    /**
     * @inheritdoc
     */
    protected function preparePaginatedResponse($request): JsonResponse
    {
        // Append query parameters if needed
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (!is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return $this->makePaginatedResponse()->toResponse($request);
    }

    /**
     * Creates a new paginated resource response
     *
     * @return PaginatedResourceResponse
     */
    protected function makePaginatedResponse(): PaginatedResourceResponse
    {
        $class = $this->paginatedResponseClass;

        return new $class($this);
    }
}