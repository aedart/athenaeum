<?php

namespace Aedart\ETags\Preconditions;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\Utils\Arr;
use DateTimeInterface;

/**
 * Generic Resource
 *
 * @see \Aedart\Contracts\ETags\Preconditions\ResourceContext
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags
 */
class GenericResource implements ResourceContext
{
    /**
     * Arbitrary data associated with this resource
     *
     * @var array Key-value store
     */
    protected array $items = [];

    /**
     * Create a new "generic" resource
     *
     * @param  mixed  $data E.g. requested record, file...etc
     * @param  ETag|null  $etag  [optional]
     * @param  DateTimeInterface|null  $lastModifiedDate  [optional]
     * @param  int  $size  [optional]
     * @param  callable|null $determineStateChangeSuccess  [optional] Callback that determines if a state change
     *                                                     has already succeeded on the resource. Callback MUST
     *                                                     return a boolean value.
     */
    public function __construct(
        protected mixed $data,
        protected ETag|null $etag = null,
        protected DateTimeInterface|null $lastModifiedDate = null,
        protected int $size = 0,
        protected $determineStateChangeSuccess = null
    ) {}

    /**
     * @inheritDoc
     */
    public function data(): mixed
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function etag(): ETag|null
    {
        return $this->etag;
    }

    /**
     * @inheritDoc
     */
    public function hasEtag(): bool
    {
        return isset($this->etag);
    }

    /**
     * @inheritDoc
     */
    public function lastModifiedDate(): DateTimeInterface|null
    {
        return $this->lastModifiedDate;
    }

    /**
     * @inheritDoc
     */
    public function hasLastModifiedDate(): bool
    {
        return isset($this->lastModifiedDate);
    }

    /**
     * @inheritDoc
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * @inheritDoc
     */
    public function supportsRangeRequest(): bool
    {
        return $this->size() > 0;
    }

    /**
     * @inheritDoc
     */
    public function hasStateChangeAlreadySucceeded($request): bool
    {
        $determineCallback = $this->determineStateChangeSuccess ?? fn () => false;

        return $determineCallback($request, $this);
    }

    /**
     * @inheritDoc
     */
    public function set(string|int $key, mixed $value): static
    {
        Arr::set($this->items, $key, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string|int $key, mixed $default = null): mixed
    {
        return Arr::get($this->items, $key, $default);
    }

    /**
     * @inheritDoc
     */
    public function has(string|int $key): bool
    {
        return Arr::has($this->items, $key);
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->items;
    }
}