<?php

namespace Aedart\ETags\Preconditions\Resources;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\Utils\Concerns;
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
    use Concerns\ArbitraryData;

    /**
     * Arbitrary data associated with this resource
     *
     * @var array Key-value store
     */
    protected array $items = [];

    /**
     * Create a new "generic" resource
     *
     * @param  mixed  $data E.g. a record, Eloquent model, a file...etc
     * @param  ETag|null  $etag  [optional]
     * @param  DateTimeInterface|null  $lastModifiedDate  [optional]
     * @param  int  $size  [optional] Size of resource. Applicable if supporting "If-Range" and "Range" requests.
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
    public function hasStateChangeAlreadySucceeded($request): bool
    {
        $determineCallback = $this->determineStateChangeSuccess ?? fn () => false;

        return $determineCallback($request, $this);
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
        // [...] A server that supports range requests MAY ignore a Range header
        // field when the selected representation has no content (i.e., the
        // selected representation's data is of zero length). [...]
        // @see https://httpwg.org/specs/rfc9110.html#field.range

        return $this->size() > 0;
    }
}