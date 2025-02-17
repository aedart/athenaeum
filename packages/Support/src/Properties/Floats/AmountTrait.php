<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Amount Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\AmountAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait AmountTrait
{
    /**
     * The quantity of something
     *
     * @var float|null
     */
    protected float|null $amount = null;

    /**
     * Set amount
     *
     * @param float|null $amount The quantity of something
     *
     * @return self
     */
    public function setAmount(float|null $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * If no amount value set, method
     * sets and returns a default amount.
     *
     * @see getDefaultAmount()
     *
     * @return float|null amount or null if no amount has been set
     */
    public function getAmount(): float|null
    {
        if (!$this->hasAmount()) {
            $this->setAmount($this->getDefaultAmount());
        }
        return $this->amount;
    }

    /**
     * Check if amount has been set
     *
     * @return bool True if amount has been set, false if not
     */
    public function hasAmount(): bool
    {
        return isset($this->amount);
    }

    /**
     * Get a default amount value, if any is available
     *
     * @return float|null Default amount value or null if no default value is available
     */
    public function getDefaultAmount(): float|null
    {
        return null;
    }
}
