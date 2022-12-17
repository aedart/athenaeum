<?php

namespace Aedart\Contracts\ETags\Preconditions;

use Aedart\Contracts\ETags\ETag;
use DateTimeInterface;

/**
 * Resource Context
 *
 * A representation of some kind of "resource" that request preconditions
 * can evaluate.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions
 */
interface ResourceContext
{
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
     * Returns the size of the resource
     *
     * @return int
     */
    public function size(): int;
}