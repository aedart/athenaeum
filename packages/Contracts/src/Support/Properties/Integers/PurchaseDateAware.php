<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Purchase date Aware
 *
 * Component is aware of int "purchase date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface PurchaseDateAware
{
    /**
     * Set purchase date
     *
     * @param int|null $date Date of planned purchase
     *
     * @return self
     */
    public function setPurchaseDate(int|null $date): static;

    /**
     * Get purchase date
     *
     * If no purchase date value set, method
     * sets and returns a default purchase date.
     *
     * @see getDefaultPurchaseDate()
     *
     * @return int|null purchase date or null if no purchase date has been set
     */
    public function getPurchaseDate(): int|null;

    /**
     * Check if purchase date has been set
     *
     * @return bool True if purchase date has been set, false if not
     */
    public function hasPurchaseDate(): bool;

    /**
     * Get a default purchase date value, if any is available
     *
     * @return int|null Default purchase date value or null if no default value is available
     */
    public function getDefaultPurchaseDate(): int|null;
}
