<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Longitude Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\LongitudeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait LongitudeTrait
{
    /**
     * East-West position on Earth&amp;#039;s surface
     *
     * @var string|null
     */
    protected string|null $longitude = null;

    /**
     * Set longitude
     *
     * @param string|null $value East-West position on Earth&amp;#039;s surface
     *
     * @return self
     */
    public function setLongitude(string|null $value): static
    {
        $this->longitude = $value;

        return $this;
    }

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
    public function getLongitude(): string|null
    {
        if (!$this->hasLongitude()) {
            $this->setLongitude($this->getDefaultLongitude());
        }
        return $this->longitude;
    }

    /**
     * Check if longitude has been set
     *
     * @return bool True if longitude has been set, false if not
     */
    public function hasLongitude(): bool
    {
        return isset($this->longitude);
    }

    /**
     * Get a default longitude value, if any is available
     *
     * @return string|null Default longitude value or null if no default value is available
     */
    public function getDefaultLongitude(): string|null
    {
        return null;
    }
}
