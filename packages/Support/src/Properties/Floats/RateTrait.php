<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Rate Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\RateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait RateTrait
{
    /**
     * The rate of something, e.g. growth rate, tax rate
     *
     * @var float|null
     */
    protected float|null $rate = null;

    /**
     * Set rate
     *
     * @param float|null $rate The rate of something, e.g. growth rate, tax rate
     *
     * @return self
     */
    public function setRate(float|null $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * If no rate value set, method
     * sets and returns a default rate.
     *
     * @see getDefaultRate()
     *
     * @return float|null rate or null if no rate has been set
     */
    public function getRate(): float|null
    {
        if (!$this->hasRate()) {
            $this->setRate($this->getDefaultRate());
        }
        return $this->rate;
    }

    /**
     * Check if rate has been set
     *
     * @return bool True if rate has been set, false if not
     */
    public function hasRate(): bool
    {
        return isset($this->rate);
    }

    /**
     * Get a default rate value, if any is available
     *
     * @return float|null Default rate value or null if no default value is available
     */
    public function getDefaultRate(): float|null
    {
        return null;
    }
}
