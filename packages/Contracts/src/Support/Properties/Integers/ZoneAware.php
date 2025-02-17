<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Zone Aware
 *
 * Component is aware of int "zone"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface ZoneAware
{
    /**
     * Set zone
     *
     * @param int|null $identifier Name or identifier of area, district or division
     *
     * @return self
     */
    public function setZone(int|null $identifier): static;

    /**
     * Get zone
     *
     * If no zone value set, method
     * sets and returns a default zone.
     *
     * @see getDefaultZone()
     *
     * @return int|null zone or null if no zone has been set
     */
    public function getZone(): int|null;

    /**
     * Check if zone has been set
     *
     * @return bool True if zone has been set, false if not
     */
    public function hasZone(): bool;

    /**
     * Get a default zone value, if any is available
     *
     * @return int|null Default zone value or null if no default value is available
     */
    public function getDefaultZone(): int|null;
}
