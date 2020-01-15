<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Region Aware
 *
 * Component is aware of string "region"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface RegionAware
{
    /**
     * Set region
     *
     * @param string|null $name Name of a region, state or province
     *
     * @return self
     */
    public function setRegion(?string $name);

    /**
     * Get region
     *
     * If no "region" value set, method
     * sets and returns a default "region".
     *
     * @see getDefaultRegion()
     *
     * @return string|null region or null if no region has been set
     */
    public function getRegion() : ?string;

    /**
     * Check if "region" has been set
     *
     * @return bool True if "region" has been set, false if not
     */
    public function hasRegion() : bool;

    /**
     * Get a default "region" value, if any is available
     *
     * @return string|null Default "region" value or null if no default value is available
     */
    public function getDefaultRegion() : ?string;
}
