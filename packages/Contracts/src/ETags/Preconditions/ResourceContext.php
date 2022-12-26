<?php

namespace Aedart\Contracts\ETags\Preconditions;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\Utils\HasArbitraryData;
use DateTimeInterface;

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
     * @see https://httpwg.org/specs/rfc9110.html#range.requests
     *
     * @return bool
     */
    public function supportsRangeRequest(): bool;
}