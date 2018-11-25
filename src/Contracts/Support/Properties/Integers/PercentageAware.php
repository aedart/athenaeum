<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * Percentage Aware
 *
 * Component is aware of int "percentage"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface PercentageAware
{
    /**
     * Set percentage
     *
     * @param int|null $percentage A part or other object per hundred
     *
     * @return self
     */
    public function setPercentage(?int $percentage);

    /**
     * Get percentage
     *
     * If no "percentage" value set, method
     * sets and returns a default "percentage".
     *
     * @see getDefaultPercentage()
     *
     * @return int|null percentage or null if no percentage has been set
     */
    public function getPercentage() : ?int;

    /**
     * Check if "percentage" has been set
     *
     * @return bool True if "percentage" has been set, false if not
     */
    public function hasPercentage() : bool;

    /**
     * Get a default "percentage" value, if any is available
     *
     * @return int|null Default "percentage" value or null if no default value is available
     */
    public function getDefaultPercentage() : ?int;
}
