<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Location Aware
 *
 * Component is aware of int "location"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface LocationAware
{
    /**
     * Set location
     *
     * @param int|null $identifier Name or identifier of a location
     *
     * @return self
     */
    public function setLocation(int|null $identifier): static;

    /**
     * Get location
     *
     * If no location value set, method
     * sets and returns a default location.
     *
     * @see getDefaultLocation()
     *
     * @return int|null location or null if no location has been set
     */
    public function getLocation(): int|null;

    /**
     * Check if location has been set
     *
     * @return bool True if location has been set, false if not
     */
    public function hasLocation(): bool;

    /**
     * Get a default location value, if any is available
     *
     * @return int|null Default location value or null if no default value is available
     */
    public function getDefaultLocation(): int|null;
}
