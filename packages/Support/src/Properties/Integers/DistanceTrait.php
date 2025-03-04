<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Distance Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\DistanceAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait DistanceTrait
{
    /**
     * Distance to or from something
     *
     * @var int|null
     */
    protected int|null $distance = null;

    /**
     * Set distance
     *
     * @param int|null $length Distance to or from something
     *
     * @return self
     */
    public function setDistance(int|null $length): static
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
     * @return int|null distance or null if no distance has been set
     */
    public function getDistance(): int|null
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
     * @return int|null Default distance value or null if no default value is available
     */
    public function getDefaultDistance(): int|null
    {
        return null;
    }
}
