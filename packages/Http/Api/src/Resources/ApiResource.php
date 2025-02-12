<?php

namespace Aedart\Http\Api\Resources;

use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Contracts\Http\Api\Resources\Relations\Exceptions\RelationReferenceException;
use Aedart\Http\Api\Responses\ApiResourceResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;
use LogicException;
use Teapot\StatusCode\All as HttpStatus;

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
    use Concerns\Relations;
    use Concerns\HttpCaching;

    /**
     * Additional payload formatting
     *
     * @var callable|null
     */
    protected $additionalFormatter = null;

    /**
     * When true and resource model is {@see Sluggable},
     * then a slug will be used as primary key
     *
     * @var bool
     */
    protected bool $useSlugAsPrimaryKey = false;

    /**
     * Format this resource's payload
     *
     * @param  Request  $request
     *
     * @return array
     */
    abstract public function formatPayload(Request $request): array;

    /**
     * Set callback that applies additional formatting on payload
     *
     * @param  callable|null  $formatter (Pre)formatted payload, {@see Request} and this {@see ApiResource} are
     *                                   given as callback arguments. Callback MUST return an array!
     *
     * @return self
     */
    public function format(callable|null $formatter): static
    {
        $this->additionalFormatter = $formatter;

        return $this;
    }

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
     * @throws RelationReferenceException
     */
    public function toArray($request): array
    {
        if (!isset($this->resource)) {
            return [];
        }

        $formatted = $this->applyAdditionalPayloadFormatting(
            $request,
            $this->formatPayload($request)
        );

        return $this->onlySelected(
            $this->resolveRelations($formatted, $request)
        );
    }

    /**
     * @inheritdoc
     */
    public function toResponse($request)
    {
        return $this->applyCacheHeaders(
            response: (new ApiResourceResponse($this))->toResponse($request),
            request: $request
        );
    }

    /**
     * Create a "201 Created" HTTP response that represents the object.
     *
     * @param  Request|null  $request  [optional]
     *
     * @return JsonResponse
     */
    public function createdResponse(Request|null $request = null): JsonResponse
    {
        return $this
            ->response($request)
            ->setStatusCode(HttpStatus::CREATED);
    }

    /**
     * Create an  HTTP response that represents the object, after
     * the resource was updated
     *
     * @param  Request|null  $request  [optional]
     *
     * @return JsonResponse
     */
    public function updatedResponse(Request|null $request = null): JsonResponse
    {
        return $this
            ->response($request)
            ->setStatusCode(HttpStatus::OK);
    }

    /**
     * Set whether model's slug should be used as primary key or not
     *
     * The resource model must inherit from {@see Sluggable} before
     * this takes effect!
     *
     * @param  bool  $use  [optional]
     *
     * @return self
     */
    public function useSlugAsPrimaryKey(bool $use = true): static
    {
        $this->useSlugAsPrimaryKey = $use;

        return $this;
    }

    /**
     * Determine if model's slug should be used as primary key
     *
     * @return bool
     */
    public function mustUseSlugAsPrimaryKey(): bool
    {
        return $this->useSlugAsPrimaryKey;
    }

    /**
     * The resource's identifier
     *
     * @return string|int|null
     */
    public function getResourceKey(): string|int|null
    {
        $key = $this->getResourceKeyName();

        return $this->resource->{$key};
    }

    /**
     * The resource's identifier key name
     *
     * @return string
     */
    public function getResourceKeyName(): string
    {
        $resource = $this->resource;

        return match (true) {
            $this->mustUseSlugAsPrimaryKey() && $resource instanceof Sluggable => $resource->getSlugKeyName(),
            $resource instanceof Model => $resource->getKeyName(),
            default => throw new LogicException(sprintf('Unable to determine resource identifier key name for %s', var_export($resource, true)))
        };
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

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Applies evt. additional payload formatting
     *
     * @param  Request  $request
     * @param  array  $payload
     *
     * @return array
     */
    protected function applyAdditionalPayloadFormatting(Request $request, array $payload): array
    {
        $callback = $this->additionalFormatter;

        if (!isset($callback)) {
            return $payload;
        }

        return $callback($payload, $request, $this);
    }
}
