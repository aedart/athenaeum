<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Production date Aware
 *
 * Component is aware of string "production date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ProductionDateAware
{
    /**
     * Set production date
     *
     * @param string|null $date Date of planned production
     *
     * @return self
     */
    public function setProductionDate(string|null $date): static;

    /**
     * Get production date
     *
     * If no production date value set, method
     * sets and returns a default production date.
     *
     * @see getDefaultProductionDate()
     *
     * @return string|null production date or null if no production date has been set
     */
    public function getProductionDate(): string|null;

    /**
     * Check if production date has been set
     *
     * @return bool True if production date has been set, false if not
     */
    public function hasProductionDate(): bool;

    /**
     * Get a default production date value, if any is available
     *
     * @return string|null Default production date value or null if no default value is available
     */
    public function getDefaultProductionDate(): string|null;
}
