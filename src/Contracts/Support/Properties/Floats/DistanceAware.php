<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * Distance Aware
 *
 * Component is aware of float "distance"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface DistanceAware
{
    /**
     * Set distance
     *
     * @param float|null $length Distance to or from something
     *
     * @return self
     */
    public function setDistance(?float $length);

    /**
     * Get distance
     *
     * If no "distance" value set, method
     * sets and returns a default "distance".
     *
     * @see getDefaultDistance()
     *
     * @return float|null distance or null if no distance has been set
     */
    public function getDistance() : ?float;

    /**
     * Check if "distance" has been set
     *
     * @return bool True if "distance" has been set, false if not
     */
    public function hasDistance() : bool;

    /**
     * Get a default "distance" value, if any is available
     *
     * @return float|null Default "distance" value or null if no default value is available
     */
    public function getDefaultDistance() : ?float;
}
