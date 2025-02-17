<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Country Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\CountryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait CountryTrait
{
    /**
     * Name of country, e.g. Denmark, United Kingdom, Australia...etc
     *
     * @var string|null
     */
    protected string|null $country = null;

    /**
     * Set country
     *
     * @param string|null $name Name of country, e.g. Denmark, United Kingdom, Australia...etc
     *
     * @return self
     */
    public function setCountry(string|null $name): static
    {
        $this->country = $name;

        return $this;
    }

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
    public function getCountry(): string|null
    {
        if (!$this->hasCountry()) {
            $this->setCountry($this->getDefaultCountry());
        }
        return $this->country;
    }

    /**
     * Check if country has been set
     *
     * @return bool True if country has been set, false if not
     */
    public function hasCountry(): bool
    {
        return isset($this->country);
    }

    /**
     * Get a default country value, if any is available
     *
     * @return string|null Default country value or null if no default value is available
     */
    public function getDefaultCountry(): string|null
    {
        return null;
    }
}
