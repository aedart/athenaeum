<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Area Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\AreaAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait AreaTrait
{
    /**
     * Name of area, e.g. in a building, in a city, outside the city, ...etc
     *
     * @var string|null
     */
    protected string|null $area = null;

    /**
     * Set area
     *
     * @param string|null $name Name of area, e.g. in a building, in a city, outside the city, ...etc
     *
     * @return self
     */
    public function setArea(string|null $name): static
    {
        $this->area = $name;

        return $this;
    }

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
    public function getArea(): string|null
    {
        if (!$this->hasArea()) {
            $this->setArea($this->getDefaultArea());
        }
        return $this->area;
    }

    /**
     * Check if area has been set
     *
     * @return bool True if area has been set, false if not
     */
    public function hasArea(): bool
    {
        return isset($this->area);
    }

    /**
     * Get a default area value, if any is available
     *
     * @return string|null Default area value or null if no default value is available
     */
    public function getDefaultArea(): string|null
    {
        return null;
    }
}
