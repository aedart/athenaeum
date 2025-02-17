<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Latitude Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\LatitudeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait LatitudeTrait
{
    /**
     * North-South position on Earth&amp;#039;s surface
     *
     * @var string|null
     */
    protected string|null $latitude = null;

    /**
     * Set latitude
     *
     * @param string|null $value North-South position on Earth&amp;#039;s surface
     *
     * @return self
     */
    public function setLatitude(string|null $value): static
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
     * @return string|null latitude or null if no latitude has been set
     */
    public function getLatitude(): string|null
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
     * @return string|null Default latitude value or null if no default value is available
     */
    public function getDefaultLatitude(): string|null
    {
        return null;
    }
}
