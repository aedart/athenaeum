<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Order number Aware
 *
 * Component is aware of int "order number"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface OrderNumberAware
{
    /**
     * Set order number
     *
     * @param int|null $number Number that represents a purchase or order placed by a customer
     *
     * @return self
     */
    public function setOrderNumber(int|null $number): static;

    /**
     * Get order number
     *
     * If no order number value set, method
     * sets and returns a default order number.
     *
     * @see getDefaultOrderNumber()
     *
     * @return int|null order number or null if no order number has been set
     */
    public function getOrderNumber(): int|null;

    /**
     * Check if order number has been set
     *
     * @return bool True if order number has been set, false if not
     */
    public function hasOrderNumber(): bool;

    /**
     * Get a default order number value, if any is available
     *
     * @return int|null Default order number value or null if no default value is available
     */
    public function getDefaultOrderNumber(): int|null;
}
