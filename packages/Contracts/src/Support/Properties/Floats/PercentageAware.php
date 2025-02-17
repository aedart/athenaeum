<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Percentage Aware
 *
 * Component is aware of float "percentage"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface PercentageAware
{
    /**
     * Set percentage
     *
     * @param float|null $percentage A proportion (especially per hundred)
     *
     * @return self
     */
    public function setPercentage(float|null $percentage): static;

    /**
     * Get percentage
     *
     * If no percentage value set, method
     * sets and returns a default percentage.
     *
     * @see getDefaultPercentage()
     *
     * @return float|null percentage or null if no percentage has been set
     */
    public function getPercentage(): float|null;

    /**
     * Check if percentage has been set
     *
     * @return bool True if percentage has been set, false if not
     */
    public function hasPercentage(): bool;

    /**
     * Get a default percentage value, if any is available
     *
     * @return float|null Default percentage value or null if no default value is available
     */
    public function getDefaultPercentage(): float|null;
}
