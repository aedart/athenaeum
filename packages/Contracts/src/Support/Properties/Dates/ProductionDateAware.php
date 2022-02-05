<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Production date Aware
 *
 * Component is aware of \DateTime "production date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface ProductionDateAware
{
    /**
     * Set production date
     *
     * @param \DateTime|null $date Date of planned production
     *
     * @return self
     */
    public function setProductionDate(\DateTime|null $date): static;

    /**
     * Get production date
     *
     * If no production date value set, method
     * sets and returns a default production date.
     *
     * @see getDefaultProductionDate()
     *
     * @return \DateTime|null production date or null if no production date has been set
     */
    public function getProductionDate(): \DateTime|null;

    /**
     * Check if production date has been set
     *
     * @return bool True if production date has been set, false if not
     */
    public function hasProductionDate(): bool;

    /**
     * Get a default production date value, if any is available
     *
     * @return \DateTime|null Default production date value or null if no default value is available
     */
    public function getDefaultProductionDate(): \DateTime|null;
}
