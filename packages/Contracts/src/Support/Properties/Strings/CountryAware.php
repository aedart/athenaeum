<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Country Aware
 *
 * Component is aware of string "country"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface CountryAware
{
    /**
     * Set country
     *
     * @param string|null $name Name of country, e.g. Denmark, United Kingdom, Australia...etc
     *
     * @return self
     */
    public function setCountry(string|null $name): static;

    /**
     * Get country
     *
     * If no country value set, method
     * sets and returns a default country.
     *
     * @see getDefaultCountry()
     *
     * @return string|null country or null if no country has been set
     */
    public function getCountry(): string|null;

    /**
     * Check if country has been set
     *
     * @return bool True if country has been set, false if not
     */
    public function hasCountry(): bool;

    /**
     * Get a default country value, if any is available
     *
     * @return string|null Default country value or null if no default value is available
     */
    public function getDefaultCountry(): string|null;
}
