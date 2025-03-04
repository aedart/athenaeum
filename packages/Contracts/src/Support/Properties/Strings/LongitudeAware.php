<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Longitude Aware
 *
 * Component is aware of string "longitude"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface LongitudeAware
{
    /**
     * Set longitude
     *
     * @param string|null $value East-West position on Earth&amp;#039;s surface
     *
     * @return self
     */
    public function setLongitude(string|null $value): static;

    /**
     * Get longitude
     *
     * If no longitude value set, method
     * sets and returns a default longitude.
     *
     * @see getDefaultLongitude()
     *
     * @return string|null longitude or null if no longitude has been set
     */
    public function getLongitude(): string|null;

    /**
     * Check if longitude has been set
     *
     * @return bool True if longitude has been set, false if not
     */
    public function hasLongitude(): bool;

    /**
     * Get a default longitude value, if any is available
     *
     * @return string|null Default longitude value or null if no default value is available
     */
    public function getDefaultLongitude(): string|null;
}
