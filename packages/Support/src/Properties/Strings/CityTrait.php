<?php

namespace Aedart\Support\Properties\Strings;

/**
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
    protected ?string $city = null;

    /**
     * Set city
     *
     * @param string|null $name Name of city, town or village
     *
     * @return self
     */
    public function setCity(?string $name)
    {
        $this->city = $name;

        return $this;
    }

    /**
     * Get city
     *
     * If no "city" value set, method
     * sets and returns a default "city".
     *
     * @see getDefaultCity()
     *
     * @return string|null city or null if no city has been set
     */
    public function getCity(): ?string
    {
        if (!$this->hasCity()) {
            $this->setCity($this->getDefaultCity());
        }
        return $this->city;
    }

    /**
     * Check if "city" has been set
     *
     * @return bool True if "city" has been set, false if not
     */
    public function hasCity(): bool
    {
        return isset($this->city);
    }

    /**
     * Get a default "city" value, if any is available
     *
     * @return string|null Default "city" value or null if no default value is available
     */
    public function getDefaultCity(): ?string
    {
        return null;
    }
}
