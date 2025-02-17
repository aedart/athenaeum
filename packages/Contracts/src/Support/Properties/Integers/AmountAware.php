<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Amount Aware
 *
 * Component is aware of int "amount"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface AmountAware
{
    /**
     * Set amount
     *
     * @param int|null $amount The quantity of something
     *
     * @return self
     */
    public function setAmount(int|null $amount): static;

    /**
     * Get amount
     *
     * If no amount value set, method
     * sets and returns a default amount.
     *
     * @see getDefaultAmount()
     *
     * @return int|null amount or null if no amount has been set
     */
    public function getAmount(): int|null;

    /**
     * Check if amount has been set
     *
     * @return bool True if amount has been set, false if not
     */
    public function hasAmount(): bool;

    /**
     * Get a default amount value, if any is available
     *
     * @return int|null Default amount value or null if no default value is available
     */
    public function getDefaultAmount(): int|null;
}
