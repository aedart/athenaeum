<?php

namespace Aedart\Contracts\ETags;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;

/**
 * Has Etag
 *
 * Offers an Etag that represents this component.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags
 */
interface HasEtag
{
    /**
     * Returns ETag that represents this component
     *
     * @param  bool  $weak  [optional] When true, ETag is flagged as "weak",
     *                      indented to be used for "weak comparison" (E.g. If-None-Match Http header comparison).
     *                      When false, ETag is not flagged as "weak",
     *                      intended to be used for "strong comparison" (E.g. If-Match Http header comparison).
     * @param  bool  $force  [optional] When true then a new ETag instance is returned.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag
     */
    public function getEtag(bool $weak = true, bool $force = false): ETag;

    /**
     * Returns "weak" flagged Etag representation of this component (intended for weak comparison)
     *
     * @param  bool  $force  [optional] When true then a new ETag instance is returned.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag
     */
    public function getWeakEtag(bool $force = false): ETag;

    /**
     * Returns Etag representation of this component (intended for strong comparison)
     *
     * @param  bool  $force  [optional] When true then a new ETag instance is returned.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag
     */
    public function getStrongEtag(bool $force = false): ETag;

    /**
     * Clears evt. cached Etag representation of thi component
     *
     * @return self
     */
    public function clearCachedEtag(): static;
}