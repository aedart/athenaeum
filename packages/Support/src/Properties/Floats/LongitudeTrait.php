<?php

namespace Aedart\Support\Properties\Floats;

/**
 * Longitude Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\LongitudeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait LongitudeTrait
{
    /**
     * East-West position on Earth&#039;s surface
     *
     * @var float|null
     */
    protected ?float $longitude = null;

    /**
     * Set longitude
     *
     * @param float|null $value East-West position on Earth&#039;s surface
     *
     * @return self
     */
    public function setLongitude(?float $value)
    {
        $this->longitude = $value;

        return $this;
    }

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
    public function getLongitude(): ?float
    {
        if (!$this->hasLongitude()) {
            $this->setLongitude($this->getDefaultLongitude());
        }
        return $this->longitude;
    }

    /**
     * Check if "longitude" has been set
     *
     * @return bool True if "longitude" has been set, false if not
     */
    public function hasLongitude(): bool
    {
        return isset($this->longitude);
    }

    /**
     * Get a default "longitude" value, if any is available
     *
     * @return float|null Default "longitude" value or null if no default value is available
     */
    public function getDefaultLongitude(): ?float
    {
        return null;
    }
}
