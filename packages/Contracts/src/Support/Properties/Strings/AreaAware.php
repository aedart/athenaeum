<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Area Aware
 *
 * Component is aware of string "area"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface AreaAware
{
    /**
     * Set area
     *
     * @param string|null $name Name of area, e.g. in a building, in a city, outside the city, ...etc
     *
     * @return self
     */
    public function setArea(string|null $name): static;

    /**
     * Get area
     *
     * If no area value set, method
     * sets and returns a default area.
     *
     * @see getDefaultArea()
     *
     * @return string|null area or null if no area has been set
     */
    public function getArea(): string|null;

    /**
     * Check if area has been set
     *
     * @return bool True if area has been set, false if not
     */
    public function hasArea(): bool;

    /**
     * Get a default area value, if any is available
     *
     * @return string|null Default area value or null if no default value is available
     */
    public function getDefaultArea(): string|null;
}
