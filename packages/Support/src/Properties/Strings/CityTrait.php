<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * City Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\CityAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait CityTrait
{
    /**
     * Name of city, town or village
     *
     * @var string|null
     */
    protected string|null $city = null;

    /**
     * Set city
     *
     * @param string|null $name Name of city, town or village
     *
     * @return self
     */
    public function setCity(string|null $name): static
    {
        $this->city = $name;

        return $this;
    }

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
    public function getCity(): string|null
    {
        if (!$this->hasCity()) {
            $this->setCity($this->getDefaultCity());
        }
        return $this->city;
    }

    /**
     * Check if city has been set
     *
     * @return bool True if city has been set, false if not
     */
    public function hasCity(): bool
    {
        return isset($this->city);
    }

    /**
     * Get a default city value, if any is available
     *
     * @return string|null Default city value or null if no default value is available
     */
    public function getDefaultCity(): string|null
    {
        return null;
    }
}
