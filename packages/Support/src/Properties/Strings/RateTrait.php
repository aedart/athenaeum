<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Rate Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\RateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait RateTrait
{
    /**
     * The rate of something, e.g. growth rate, tax rate
     *
     * @var string|null
     */
    protected string|null $rate = null;

    /**
     * Set rate
     *
     * @param string|null $rate The rate of something, e.g. growth rate, tax rate
     *
     * @return self
     */
    public function setRate(string|null $rate): static
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
     * @return string|null rate or null if no rate has been set
     */
    public function getRate(): string|null
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
     * @return string|null Default rate value or null if no default value is available
     */
    public function getDefaultRate(): string|null
    {
        return null;
    }
}
