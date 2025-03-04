<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Discount Aware
 *
 * Component is aware of string "discount"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface DiscountAware
{
    /**
     * Set discount
     *
     * @param string|null $amount Discount amount
     *
     * @return self
     */
    public function setDiscount(string|null $amount): static;

    /**
     * Get discount
     *
     * If no discount value set, method
     * sets and returns a default discount.
     *
     * @see getDefaultDiscount()
     *
     * @return string|null discount or null if no discount has been set
     */
    public function getDiscount(): string|null;

    /**
     * Check if discount has been set
     *
     * @return bool True if discount has been set, false if not
     */
    public function hasDiscount(): bool;

    /**
     * Get a default discount value, if any is available
     *
     * @return string|null Default discount value or null if no default value is available
     */
    public function getDefaultDiscount(): string|null;
}
