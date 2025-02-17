<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Price Aware
 *
 * Component is aware of float "price"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface PriceAware
{
    /**
     * Set price
     *
     * @param float|null $amount Numeric price
     *
     * @return self
     */
    public function setPrice(float|null $amount): static;

    /**
     * Get price
     *
     * If no price value set, method
     * sets and returns a default price.
     *
     * @see getDefaultPrice()
     *
     * @return float|null price or null if no price has been set
     */
    public function getPrice(): float|null;

    /**
     * Check if price has been set
     *
     * @return bool True if price has been set, false if not
     */
    public function hasPrice(): bool;

    /**
     * Get a default price value, if any is available
     *
     * @return float|null Default price value or null if no default value is available
     */
    public function getDefaultPrice(): float|null;
}
