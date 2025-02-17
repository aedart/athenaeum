<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Amount Aware
 *
 * Component is aware of float "amount"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface AmountAware
{
    /**
     * Set amount
     *
     * @param float|null $amount The quantity of something
     *
     * @return self
     */
    public function setAmount(float|null $amount): static;

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
    public function getAmount(): float|null;

    /**
     * Check if amount has been set
     *
     * @return bool True if amount has been set, false if not
     */
    public function hasAmount(): bool;

    /**
     * Get a default amount value, if any is available
     *
     * @return float|null Default amount value or null if no default value is available
     */
    public function getDefaultAmount(): float|null;
}
