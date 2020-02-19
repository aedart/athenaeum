<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * Longitude Aware
 *
 * Component is aware of float "longitude"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface LongitudeAware
{
    /**
     * Set longitude
     *
     * @param float|null $value East-West position on Earth&#039;s surface
     *
     * @return self
     */
    public function setLongitude(?float $value);

    /**
     * Get longitude
     *
     * If no "longitude" value set, method
     * sets and returns a default "longitude".
     *
     * @see getDefaultLongitude()
     *
     * @return float|null longitude or null if no longitude has been set
     */
    public function getLongitude(): ?float;

    /**
     * Check if "longitude" has been set
     *
     * @return bool True if "longitude" has been set, false if not
     */
    public function hasLongitude(): bool;

    /**
     * Get a default "longitude" value, if any is available
     *
     * @return float|null Default "longitude" value or null if no default value is available
     */
    public function getDefaultLongitude(): ?float;
}
