<?php

namespace Aedart\Http\Api\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;

/**
 * Paginated Api Resource Response
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Responses
 */
class PaginatedApiResourceResponse extends PaginatedResourceResponse
{
    /**
     * The "self" (path) key name
     *
     * @var string
     */
    protected string $selfKeyName = 'self';

    /**
     * Set the "self" (path) key name
     *
     * @param  string  $key
     *
     * @return self
     */
    public function usingSelfKey(string $key): static
    {
        $this->selfKeyName = $key;

        return $this;
    }

    /**
     * Returns the "self" (path) key name
     *
     * @return string
     */
    public function getSelfKeyName(): string
    {
        return $this->selfKeyName;
    }

    /**
     * @inheritdoc
     */
    protected function paginationInformation($request): array
    {
        $paginated = $this->resource->resource->toArray();

        $default = $this->applyDefaultPaginationInformationFormatting($paginated, $request);

        // Allow custom overwrite of pagination information, by the actual resource...
        if (method_exists($this->resource, 'paginationInformation')) {
            return $this->resource->paginationInformation($request, $paginated, $default);
        }

        return $default;
    }

    /**
     * Formats given paginated data
     *
     * @param  array  $paginated
     * @param  Request|null  $request  [optional]
     *
     * @return array
     */
    protected function applyDefaultPaginationInformationFormatting(array $paginated, Request|null $request = null): array
    {
        return [
            'meta' => array_merge(
                $this->paginationLinks($paginated),
                $this->meta($paginated)
            )
        ];
    }

    /**
     * @inheritdoc
     */
    protected function meta($paginated): array
    {
        $output = parent::meta($paginated);

        // Add the "self" key name
        $output = array_merge([
            $this->getSelfKeyName() => $output['path']
        ], $output);

        // Remove path and links.
        unset($output['path'], $output['links']);

        return $output;
    }
}