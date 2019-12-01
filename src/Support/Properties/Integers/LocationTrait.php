<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Location Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\LocationAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait LocationTrait
{
    /**
     * Name or identifier of a location
     *
     * @var int|null
     */
    protected ?int $location = null;

    /**
     * Set location
     *
     * @param int|null $identifier Name or identifier of a location
     *
     * @return self
     */
    public function setLocation(?int $identifier)
    {
        $this->location = $identifier;

        return $this;
    }

    /**
     * Get location
     *
     * If no "location" value set, method
     * sets and returns a default "location".
     *
     * @see getDefaultLocation()
     *
     * @return int|null location or null if no location has been set
     */
    public function getLocation() : ?int
    {
        if ( ! $this->hasLocation()) {
            $this->setLocation($this->getDefaultLocation());
        }
        return $this->location;
    }

    /**
     * Check if "location" has been set
     *
     * @return bool True if "location" has been set, false if not
     */
    public function hasLocation() : bool
    {
        return isset($this->location);
    }

    /**
     * Get a default "location" value, if any is available
     *
     * @return int|null Default "location" value or null if no default value is available
     */
    public function getDefaultLocation() : ?int
    {
        return null;
    }
}
