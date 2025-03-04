<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Price Aware
 *
 * Component is aware of int "price"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface PriceAware
{
    /**
     * Set price
     *
     * @param int|null $amount Numeric price
     *
     * @return self
     */
    public function setPrice(int|null $amount): static;

    /**
     * Get price
     *
     * If no price value set, method
     * sets and returns a default price.
     *
     * @see getDefaultPrice()
     *
     * @return int|null price or null if no price has been set
     */
    public function getPrice(): int|null;

    /**
     * Check if price has been set
     *
     * @return bool True if price has been set, false if not
     */
    public function hasPrice(): bool;

    /**
     * Get a default price value, if any is available
     *
     * @return int|null Default price value or null if no default value is available
     */
    public function getDefaultPrice(): int|null;
}
