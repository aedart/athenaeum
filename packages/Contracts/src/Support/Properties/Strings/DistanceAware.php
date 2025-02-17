<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Distance Aware
 *
 * Component is aware of string "distance"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface DistanceAware
{
    /**
     * Set distance
     *
     * @param string|null $length Distance to or from something
     *
     * @return self
     */
    public function setDistance(string|null $length): static;

    /**
     * Get distance
     *
     * If no distance value set, method
     * sets and returns a default distance.
     *
     * @see getDefaultDistance()
     *
     * @return string|null distance or null if no distance has been set
     */
    public function getDistance(): string|null;

    /**
     * Check if distance has been set
     *
     * @return bool True if distance has been set, false if not
     */
    public function hasDistance(): bool;

    /**
     * Get a default distance value, if any is available
     *
     * @return string|null Default distance value or null if no default value is available
     */
    public function getDefaultDistance(): string|null;
}
