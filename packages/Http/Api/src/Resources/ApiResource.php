<?php

namespace Aedart\Http\Api\Resources;

use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Http\Api\Resources\Concerns;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;

/**
 * Api Resource
 *
 * Specialised abstraction of Laravel's `JsonResource`
 *
 * @see JsonResource
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources
 */
abstract class ApiResource extends JsonResource
{
    use Concerns\ResourceType;
    use Concerns\SelfLink;
    use Concerns\Timestamps;
    use Concerns\FieldSelection;

    /**
     * Returns the Api resource collection to be used
     *
     * @return string Class path
     */
    abstract public static function collectionResource(): string;

    /**
     * Format this resource's payload
     *
     * @param  Request  $request
     *
     * @return array
     */
    abstract public function formatPayload(Request $request): array;

    /**
     * {@inheritdoc}
     *
     * @throws ValidationException
     */
    public function toArray($request): array
    {
        return $this->onlySelected(
            $this->formatPayload($request)
        );
    }

    /**
     * The resource's identifier
     *
     * @return string|int|null
     */
    public function getResourceKey(): string|int|null
    {
        if ($this->resource instanceof Sluggable) {
            return $this->resource->getSlugKey();
        }

        return $this->resource->getKey();
    }
}