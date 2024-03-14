<?php

namespace Aedart\ETags\Preconditions\Resources;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Preconditions\Ranges\RangeSet;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Facades\Generator;
use Aedart\Utils\Concerns;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Ramsey\Collection\CollectionInterface;
use SplFileInfo;

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
     * Requested range sets
     *
     * @var CollectionInterface<RangeSet>|null
     */
    protected CollectionInterface|null $ranges = null;

    /**
     * Create a new "generic" resource
     *
     * @param  mixed  $data E.g. a record, Eloquent model, a file...etc
     * @param  ETag|callable|null  $etag  [optional] When callback is given, then etag is resolved from callback.
     * @param  DateTimeInterface|null  $lastModifiedDate  [optional]
     * @param  int  $size  [optional] Size of resource. Applicable if supporting "If-Range" and "Range" requests.
     * @param  callable|null $determineStateChangeSuccess  [optional] Callback that determines if a state change
     *                                                     has already succeeded on the resource. Callback MUST
     *                                                     return a boolean value.
     * @param  string  $rangeUnit  [optional] Allowed or supported range unit, e.g. bytes.
     * @param  int  $maxRangeSets  [optional] Maximum allowed range sets.
     */
    public function __construct(
        protected mixed $data,
        protected $etag = null,
        protected DateTimeInterface|null $lastModifiedDate = null,
        protected int $size = 0,
        protected $determineStateChangeSuccess = null,
        protected string $rangeUnit = 'bytes',
        protected int $maxRangeSets = 5
    ) {
    }

    /**
     * Creates a new "generic" resource for given file
     *
     * @param SplFileInfo $file
     * @param ETag|callable|null $etag [optional] Resolves to a checksum of file, when none given.
     * @param DateTimeInterface|null $lastModifiedDate [optional] Resolve to file's last modified date, when none given.
     * @param callable|null $determineStateChangeSuccess [optional] Callback that determines if a state change
     *                                                   has already succeeded on the resource. Callback MUST
     *                                                   return a boolean value.
     * @param string $rangeUnit [optional] Allowed or supported range unit, e.g. bytes.
     * @param int $maxRangeSets [optional] Maximum allowed range sets.
     * @return static
     */
    public static function forFile(
        SplFileInfo $file,
        ETag|callable|null $etag = null,
        DateTimeInterface|null $lastModifiedDate = null,
        callable|null $determineStateChangeSuccess = null,
        string $rangeUnit = 'bytes',
        int $maxRangeSets = 5
    ): static {
        // Resolve etag and last modified date, when not given.
        $etag = $etag ?? static::makeEtagForFile($file);
        $lastModifiedDate = $lastModifiedDate ?? Carbon::createFromTimestamp($file->getMTime());

        // Return new instance
        return new static(
            data: $file,
            etag: $etag,
            lastModifiedDate: $lastModifiedDate,
            size: $file->getSize(),
            determineStateChangeSuccess: $determineStateChangeSuccess,
            rangeUnit: $rangeUnit,
            maxRangeSets: $maxRangeSets
        );
    }

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
        if (is_callable($this->etag)) {
            $callback = $this->etag;

            return $this->etag = $callback($this);
        }

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

    /**
     * @inheritDoc
     */
    public function allowedRangeUnit(): string
    {
        return $this->rangeUnit;
    }

    /**
     * @inheritDoc
     */
    public function maximumRangeSets(): int
    {
        return $this->maxRangeSets;
    }

    /**
     * @inheritDoc
     */
    public function setRequestedRanges(CollectionInterface|null $ranges = null): static
    {
        $this->ranges = $ranges;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function ranges(): CollectionInterface|null
    {
        return $this->ranges;
    }

    /**
     * @inheritDoc
     */
    public function mustProcessRange(): bool
    {
        $ranges = $this->ranges();

        return $this->supportsRangeRequest() && isset($ranges) && !$ranges->isEmpty();
    }

    /**
     * @inheritDoc
     */
    public function mustIgnoreRange(): bool
    {
        return !$this->mustProcessRange();
    }

    /**
     * Generates Etag for file
     *
     * @param SplFileInfo $file
     *
     * @return ETag
     */
    protected static function makeEtagForFile(SplFileInfo $file): ETag
    {
        $checksum = hash_file('xxh128', $file->getRealPath());

        return Generator::makeRaw($checksum);
    }
}
