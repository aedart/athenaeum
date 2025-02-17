<?php

namespace Aedart\Contracts\Support\Properties\Booleans;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Off Aware
 *
 * Component is aware of bool "off"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Booleans
 */
interface OffAware
{
    /**
     * Set off
     *
     * @param bool|null $isOff Is off
     *
     * @return self
     */
    public function setOff(bool|null $isOff): static;

    /**
     * Get off
     *
     * If no off value set, method
     * sets and returns a default off.
     *
     * @see getDefaultOff()
     *
     * @return bool|null off or null if no off has been set
     */
    public function getOff(): bool|null;

    /**
     * Check if off has been set
     *
     * @return bool True if off has been set, false if not
     */
    public function hasOff(): bool;

    /**
     * Get a default off value, if any is available
     *
     * @return bool|null Default off value or null if no default value is available
     */
    public function getDefaultOff(): bool|null;
}
