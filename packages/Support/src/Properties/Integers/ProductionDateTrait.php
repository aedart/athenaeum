<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Production date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\ProductionDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait ProductionDateTrait
{
    /**
     * Date of planned production
     *
     * @var int|null
     */
    protected ?int $productionDate = null;

    /**
     * Set production date
     *
     * @param int|null $date Date of planned production
     *
     * @return self
     */
    public function setProductionDate(?int $date)
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
     * @return int|null production date or null if no production date has been set
     */
    public function getProductionDate(): ?int
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
     * @return int|null Default "production date" value or null if no default value is available
     */
    public function getDefaultProductionDate(): ?int
    {
        return null;
    }
}
