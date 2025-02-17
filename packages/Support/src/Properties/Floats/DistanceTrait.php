<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Distance Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\DistanceAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait DistanceTrait
{
    /**
     * Distance to or from something
     *
     * @var float|null
     */
    protected float|null $distance = null;

    /**
     * Set distance
     *
     * @param float|null $length Distance to or from something
     *
     * @return self
     */
    public function setDistance(float|null $length): static
    {
        $this->distance = $length;

        return $this;
    }

    /**
     * Get distance
     *
     * If no distance value set, method
     * sets and returns a default distance.
     *
     * @see getDefaultDistance()
     *
     * @return float|null distance or null if no distance has been set
     */
    public function getDistance(): float|null
    {
        if (!$this->hasDistance()) {
            $this->setDistance($this->getDefaultDistance());
        }
        return $this->distance;
    }

    /**
     * Check if distance has been set
     *
     * @return bool True if distance has been set, false if not
     */
    public function hasDistance(): bool
    {
        return isset($this->distance);
    }

    /**
     * Get a default distance value, if any is available
     *
     * @return float|null Default distance value or null if no default value is available
     */
    public function getDefaultDistance(): float|null
    {
        return null;
    }
}
