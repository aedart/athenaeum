<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Region Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\RegionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait RegionTrait
{
    /**
     * Name of a region, state or province
     *
     * @var string|null
     */
    protected string|null $region = null;

    /**
     * Set region
     *
     * @param string|null $name Name of a region, state or province
     *
     * @return self
     */
    public function setRegion(string|null $name): static
    {
        $this->region = $name;

        return $this;
    }

    /**
     * Get region
     *
     * If no region value set, method
     * sets and returns a default region.
     *
     * @see getDefaultRegion()
     *
     * @return string|null region or null if no region has been set
     */
    public function getRegion(): string|null
    {
        if (!$this->hasRegion()) {
            $this->setRegion($this->getDefaultRegion());
        }
        return $this->region;
    }

    /**
     * Check if region has been set
     *
     * @return bool True if region has been set, false if not
     */
    public function hasRegion(): bool
    {
        return isset($this->region);
    }

    /**
     * Get a default region value, if any is available
     *
     * @return string|null Default region value or null if no default value is available
     */
    public function getDefaultRegion(): string|null
    {
        return null;
    }
}
