<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Location Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\LocationAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait LocationTrait
{
    /**
     * Name or identifier of a location
     *
     * @var string|null
     */
    protected string|null $location = null;

    /**
     * Set location
     *
     * @param string|null $identifier Name or identifier of a location
     *
     * @return self
     */
    public function setLocation(string|null $identifier): static
    {
        $this->location = $identifier;

        return $this;
    }

    /**
     * Get location
     *
     * If no location value set, method
     * sets and returns a default location.
     *
     * @see getDefaultLocation()
     *
     * @return string|null location or null if no location has been set
     */
    public function getLocation(): string|null
    {
        if (!$this->hasLocation()) {
            $this->setLocation($this->getDefaultLocation());
        }
        return $this->location;
    }

    /**
     * Check if location has been set
     *
     * @return bool True if location has been set, false if not
     */
    public function hasLocation(): bool
    {
        return isset($this->location);
    }

    /**
     * Get a default location value, if any is available
     *
     * @return string|null Default location value or null if no default value is available
     */
    public function getDefaultLocation(): string|null
    {
        return null;
    }
}
