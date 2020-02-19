<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Production date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ProductionDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ProductionDateTrait
{
    /**
     * Date of planned production
     *
     * @var string|null
     */
    protected ?string $productionDate = null;

    /**
     * Set production date
     *
     * @param string|null $date Date of planned production
     *
     * @return self
     */
    public function setProductionDate(?string $date)
    {
        $this->productionDate = $date;

        return $this;
    }

    /**
     * Get production date
     *
     * If no "production date" value set, method
     * sets and returns a default "production date".
     *
     * @see getDefaultProductionDate()
     *
     * @return string|null production date or null if no production date has been set
     */
    public function getProductionDate(): ?string
    {
        if (!$this->hasProductionDate()) {
            $this->setProductionDate($this->getDefaultProductionDate());
        }
        return $this->productionDate;
    }

    /**
     * Check if "production date" has been set
     *
     * @return bool True if "production date" has been set, false if not
     */
    public function hasProductionDate(): bool
    {
        return isset($this->productionDate);
    }

    /**
     * Get a default "production date" value, if any is available
     *
     * @return string|null Default "production date" value or null if no default value is available
     */
    public function getDefaultProductionDate(): ?string
    {
        return null;
    }
}
