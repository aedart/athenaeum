<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Latitude Aware
 *
 * Component is aware of float "latitude"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface LatitudeAware
{
    /**
     * Set latitude
     *
     * @param float|null $value North-South position on Earth&amp;#039;s surface
     *
     * @return self
     */
    public function setLatitude(float|null $value): static;

    /**
     * Get latitude
     *
     * If no latitude value set, method
     * sets and returns a default latitude.
     *
     * @see getDefaultLatitude()
     *
     * @return float|null latitude or null if no latitude has been set
     */
    public function getLatitude(): float|null;

    /**
     * Check if latitude has been set
     *
     * @return bool True if latitude has been set, false if not
     */
    public function hasLatitude(): bool;

    /**
     * Get a default latitude value, if any is available
     *
     * @return float|null Default latitude value or null if no default value is available
     */
    public function getDefaultLatitude(): float|null;
}
