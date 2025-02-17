<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * City Aware
 *
 * Component is aware of string "city"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface CityAware
{
    /**
     * Set city
     *
     * @param string|null $name Name of city, town or village
     *
     * @return self
     */
    public function setCity(string|null $name): static;

    /**
     * Get city
     *
     * If no city value set, method
     * sets and returns a default city.
     *
     * @see getDefaultCity()
     *
     * @return string|null city or null if no city has been set
     */
    public function getCity(): string|null;

    /**
     * Check if city has been set
     *
     * @return bool True if city has been set, false if not
     */
    public function hasCity(): bool;

    /**
     * Get a default city value, if any is available
     *
     * @return string|null Default city value or null if no default value is available
     */
    public function getDefaultCity(): string|null;
}
