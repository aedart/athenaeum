<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Quantity Aware
 *
 * Component is aware of float "quantity"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface QuantityAware
{
    /**
     * Set quantity
     *
     * @param float|null $quantity The quantity of something
     *
     * @return self
     */
    public function setQuantity(float|null $quantity): static;

    /**
     * Get quantity
     *
     * If no quantity value set, method
     * sets and returns a default quantity.
     *
     * @see getDefaultQuantity()
     *
     * @return float|null quantity or null if no quantity has been set
     */
    public function getQuantity(): float|null;

    /**
     * Check if quantity has been set
     *
     * @return bool True if quantity has been set, false if not
     */
    public function hasQuantity(): bool;

    /**
     * Get a default quantity value, if any is available
     *
     * @return float|null Default quantity value or null if no default value is available
     */
    public function getDefaultQuantity(): float|null;
}
