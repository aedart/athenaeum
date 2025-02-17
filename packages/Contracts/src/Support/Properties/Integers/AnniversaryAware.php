<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Anniversary Aware
 *
 * Component is aware of int "anniversary"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface AnniversaryAware
{
    /**
     * Set anniversary
     *
     * @param int|null $anniversary Date of anniversary
     *
     * @return self
     */
    public function setAnniversary(int|null $anniversary): static;

    /**
     * Get anniversary
     *
     * If no anniversary value set, method
     * sets and returns a default anniversary.
     *
     * @see getDefaultAnniversary()
     *
     * @return int|null anniversary or null if no anniversary has been set
     */
    public function getAnniversary(): int|null;

    /**
     * Check if anniversary has been set
     *
     * @return bool True if anniversary has been set, false if not
     */
    public function hasAnniversary(): bool;

    /**
     * Get a default anniversary value, if any is available
     *
     * @return int|null Default anniversary value or null if no default value is available
     */
    public function getDefaultAnniversary(): int|null;
}
