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
     * Format this resource's payload
     *
     * @param  Request  $request
     *
     * @return array
     */
    abstract public function formatPayload(Request $request): array;

    /**
     * @inheritdoc
     */
    public static function collection($resource)
    {
        // Laravel's JsonResource is hardcoded to use `AnonymousResourceCollection`, which we
        // overwrite here to allow customised collections to be used.

        return tap(static::makeResourceCollection($resource), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }

    /**
     * Returns a new Api Resource Collection instance
     *
     * @param  mixed  $resource
     *
     * @return ApiResourceCollection
     */
    public static function makeResourceCollection(mixed $resource): ApiResourceCollection
    {
        return new AnonymousApiResourceCollection($resource, static::class);
    }

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

    /**
     * @inheritdoc
     */
    public function with($request)
    {
        return array_merge([
            'meta' => $this->meta($request)
        ], parent::with($request));
    }

    /**
     * Creates meta information for this resource
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function meta(Request $request): array
    {
        return [
            'type' => $this->type(),
            'self' => $this->makeSelfLink($request)
        ];
    }
}