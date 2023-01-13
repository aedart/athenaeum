<?php

namespace Aedart\Contracts\ETags\Preconditions;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\Utils\HasArbitraryData;
use DateTimeInterface;
use Ramsey\Collection\CollectionInterface;
use Ramsey\Http\Range\Unit\UnitRangeInterface;

/**
 * Resource Context
 *
 * A representation of a "resource" that request preconditions can evaluate.
 * The context can also hold state change information, which can be altered
 * or set by preconditions, if needed.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions
 */
interface ResourceContext extends HasArbitraryData
{
    /**
     * Returns resource's data
     *
     * @return mixed E.g. the requested record, file,...etc
     */
    public function data(): mixed;

    /**
     * Returns etag representation of resource
     *
     * @return ETag|null
     */
    public function etag(): ETag|null;

    /**
     * Determine if resource has an etag
     *
     * @return bool
     */
    public function hasEtag(): bool;

    /**
     * Returns last modification date of resource
     *
     * @return DateTimeInterface|null
     */
    public function lastModifiedDate(): DateTimeInterface|null;

    /**
     * Determine if resource has a last modification date
     *
     * @return bool
     */
    public function hasLastModifiedDate(): bool;

    /**
     * Determine if state change has already succeeded for resource.
     *
     * Example: If a DELETE request is made and the resource is already deleted,
     * then this method can return true.
     *
     * Determining state change success is valid for "If-Match" or "If-Unmodified-Since" http
     * conditional requests, when they are evaluated to false, for none-safe request methods,
     * such as POST, PUT, DELETE... etc.
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-match
     * @see https://httpwg.org/specs/rfc9110.html#field.if-modified-since
     * @see https://httpwg.org/specs/rfc9110.html#precedence
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function hasStateChangeAlreadySucceeded($request): bool;

    /**
     * Returns the size of the resource
     *
     * @return int
     */
    public function size(): int;

    /**
     * Determine if resource supports "Range" request
     *
     * If {@see size()} returns 0 (zero), then this method must
     * return false. Range request are not supported for resources
     * that do not have content size specified.
     *
     * @see https://httpwg.org/specs/rfc9110.html#range.requests
     *
     * @return bool
     */
    public function supportsRangeRequest(): bool;

    /**
     * Returns the allowed or supported range unit
     *
     * @see https://httpwg.org/specs/rfc9110.html#range.units
     *
     * @return string E.g. bytes
     */
    public function allowedRangeUnit(): string;

    /**
     * Returns the maximum allowed or supported range sets
     *
     * @see https://httpwg.org/specs/rfc9110.html#range.specifiers
     *
     * @return int
     */
    public function maximumRangeSets(): int;

    /**
     * Set the requested range sets for this resource's content
     *
     * @see mustProcessRange()
     * @see https://httpwg.org/specs/rfc9110.html#field.if-range
     * @see https://httpwg.org/specs/rfc9110.html#range.requests
     *
     * @param  CollectionInterface<UnitRangeInterface>|null  $ranges  [optional]
     *
     * @return self
     */
    public function setRequestedRanges(CollectionInterface|null $ranges = null): static;

    /**
     * Returns the requested range sets of this resource's content
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-range
     * @see https://httpwg.org/specs/rfc9110.html#range.requests
     *
     * @return CollectionInterface<UnitRangeInterface>|null
     */
    public function ranges(): CollectionInterface|null;

    /**
     * Determine if "Range" header field must be processed or not
     *
     * Method must return true if;
     *
     *      a) This resource supports range requests
     *      b) This resource has valid range sets available
     *
     * When true, the application MUST react upon this and produce an appropriate
     * "206 Partial Content" response.
     *
     * @see supportsRangeRequest()
     * @see ranges()
     * @see https://httpwg.org/specs/rfc9110.html#field.if-range
     * @see https://httpwg.org/specs/rfc9110.html#range.requests
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/206
     *
     * @return bool
     */
    public function mustProcessRange(): bool;

    /**
     * Inverse of {@see mustProcessRange()}
     *
     * @return bool
     */
    public function mustIgnoreRange(): bool;
}
