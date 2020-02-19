<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * Rate Aware
 *
 * Component is aware of float "rate"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface RateAware
{
    /**
     * Set rate
     *
     * @param float|null $rate The rate of something, e.g. growth rate, tax rate
     *
     * @return self
     */
    public function setRate(?float $rate);

    /**
     * Get rate
     *
     * If no "rate" value set, method
     * sets and returns a default "rate".
     *
     * @see getDefaultRate()
     *
     * @return float|null rate or null if no rate has been set
     */
    public function getRate(): ?float;

    /**
     * Check if "rate" has been set
     *
     * @return bool True if "rate" has been set, false if not
     */
    public function hasRate(): bool;

    /**
     * Get a default "rate" value, if any is available
     *
     * @return float|null Default "rate" value or null if no default value is available
     */
    public function getDefaultRate(): ?float;
}
