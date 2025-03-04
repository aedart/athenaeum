<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Anniversary Aware
 *
 * Component is aware of string "anniversary"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface AnniversaryAware
{
    /**
     * Set anniversary
     *
     * @param string|null $anniversary Date of anniversary
     *
     * @return self
     */
    public function setAnniversary(string|null $anniversary): static;

    /**
     * Get anniversary
     *
     * If no anniversary value set, method
     * sets and returns a default anniversary.
     *
     * @see getDefaultAnniversary()
     *
     * @return string|null anniversary or null if no anniversary has been set
     */
    public function getAnniversary(): string|null;

    /**
     * Check if anniversary has been set
     *
     * @return bool True if anniversary has been set, false if not
     */
    public function hasAnniversary(): bool;

    /**
     * Get a default anniversary value, if any is available
     *
     * @return string|null Default anniversary value or null if no default value is available
     */
    public function getDefaultAnniversary(): string|null;
}
