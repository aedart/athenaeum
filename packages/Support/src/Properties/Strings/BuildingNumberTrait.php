<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Building number Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\BuildingNumberAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait BuildingNumberTrait
{
    /**
     * The house number assigned to a building or apartment in a street or area, e.g. 12a
     *
     * @var string|null
     */
    protected string|null $buildingNumber = null;

    /**
     * Set building number
     *
     * @param string|null $number The house number assigned to a building or apartment in a street or area, e.g. 12a
     *
     * @return self
     */
    public function setBuildingNumber(string|null $number): static
    {
        $this->buildingNumber = $number;

        return $this;
    }

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
    public function getBuildingNumber(): string|null
    {
        if (!$this->hasBuildingNumber()) {
            $this->setBuildingNumber($this->getDefaultBuildingNumber());
        }
        return $this->buildingNumber;
    }

    /**
     * Check if building number has been set
     *
     * @return bool True if building number has been set, false if not
     */
    public function hasBuildingNumber(): bool
    {
        return isset($this->buildingNumber);
    }

    /**
     * Get a default building number value, if any is available
     *
     * @return string|null Default building number value or null if no default value is available
     */
    public function getDefaultBuildingNumber(): string|null
    {
        return null;
    }
}
