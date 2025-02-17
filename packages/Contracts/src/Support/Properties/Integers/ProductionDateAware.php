<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Production date Aware
 *
 * Component is aware of int "production date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface ProductionDateAware
{
    /**
     * Set production date
     *
     * @param int|null $date Date of planned production
     *
     * @return self
     */
    public function setProductionDate(int|null $date): static;

    /**
     * Get production date
     *
     * If no production date value set, method
     * sets and returns a default production date.
     *
     * @see getDefaultProductionDate()
     *
     * @return int|null production date or null if no production date has been set
     */
    public function getProductionDate(): int|null;

    /**
     * Check if production date has been set
     *
     * @return bool True if production date has been set, false if not
     */
    public function hasProductionDate(): bool;

    /**
     * Get a default production date value, if any is available
     *
     * @return int|null Default production date value or null if no default value is available
     */
    public function getDefaultProductionDate(): int|null;
}
