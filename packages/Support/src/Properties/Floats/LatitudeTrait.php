<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Latitude Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\LatitudeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait LatitudeTrait
{
    /**
     * North-South position on Earth&amp;#039;s surface
     *
     * @var float|null
     */
    protected float|null $latitude = null;

    /**
     * Set latitude
     *
     * @param float|null $value North-South position on Earth&amp;#039;s surface
     *
     * @return self
     */
    public function setLatitude(float|null $value): static
    {
        $this->latitude = $value;

        return $this;
    }

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
    public function getLatitude(): float|null
    {
        if (!$this->hasLatitude()) {
            $this->setLatitude($this->getDefaultLatitude());
        }
        return $this->latitude;
    }

    /**
     * Check if latitude has been set
     *
     * @return bool True if latitude has been set, false if not
     */
    public function hasLatitude(): bool
    {
        return isset($this->latitude);
    }

    /**
     * Get a default latitude value, if any is available
     *
     * @return float|null Default latitude value or null if no default value is available
     */
    public function getDefaultLatitude(): float|null
    {
        return null;
    }
}
