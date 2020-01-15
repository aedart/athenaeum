<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * Quantity Aware
 *
 * Component is aware of int "quantity"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface QuantityAware
{
    /**
     * Set quantity
     *
     * @param int|null $quantity The quantity of something
     *
     * @return self
     */
    public function setQuantity(?int $quantity);

    /**
     * Get quantity
     *
     * If no "quantity" value set, method
     * sets and returns a default "quantity".
     *
     * @see getDefaultQuantity()
     *
     * @return int|null quantity or null if no quantity has been set
     */
    public function getQuantity() : ?int;

    /**
     * Check if "quantity" has been set
     *
     * @return bool True if "quantity" has been set, false if not
     */
    public function hasQuantity() : bool;

    /**
     * Get a default "quantity" value, if any is available
     *
     * @return int|null Default "quantity" value or null if no default value is available
     */
    public function getDefaultQuantity() : ?int;
}
