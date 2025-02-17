<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Rate Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\RateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait RateTrait
{
    /**
     * The rate of something, e.g. growth rate, tax rate
     *
     * @var int|null
     */
    protected int|null $rate = null;

    /**
     * Set rate
     *
     * @param int|null $rate The rate of something, e.g. growth rate, tax rate
     *
     * @return self
     */
    public function setRate(int|null $rate): static
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
     * @return int|null rate or null if no rate has been set
     */
    public function getRate(): int|null
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
     * @return int|null Default rate value or null if no default value is available
     */
    public function getDefaultRate(): int|null
    {
        return null;
    }
}
