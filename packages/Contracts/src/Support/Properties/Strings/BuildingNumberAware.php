<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Building number Aware
 *
 * Component is aware of string "building number"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface BuildingNumberAware
{
    /**
     * Set building number
     *
     * @param string|null $number The house number assigned to a building or apartment in a street or area, e.g. 12a
     *
     * @return self
     */
    public function setBuildingNumber(string|null $number): static;

    /**
     * Get building number
     *
     * If no building number value set, method
     * sets and returns a default building number.
     *
     * @see getDefaultBuildingNumber()
     *
     * @return string|null building number or null if no building number has been set
     */
    public function getBuildingNumber(): string|null;

    /**
     * Check if building number has been set
     *
     * @return bool True if building number has been set, false if not
     */
    public function hasBuildingNumber(): bool;

    /**
     * Get a default building number value, if any is available
     *
     * @return string|null Default building number value or null if no default value is available
     */
    public function getDefaultBuildingNumber(): string|null;
}
