<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Order number Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\OrderNumberAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait OrderNumberTrait
{
    /**
     * Number that represents a purchase or order placed by a customer
     *
     * @var int|null
     */
    protected int|null $orderNumber = null;

    /**
     * Set order number
     *
     * @param int|null $number Number that represents a purchase or order placed by a customer
     *
     * @return self
     */
    public function setOrderNumber(int|null $number): static
    {
        $this->orderNumber = $number;

        return $this;
    }

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
    public function getOrderNumber(): int|null
    {
        if (!$this->hasOrderNumber()) {
            $this->setOrderNumber($this->getDefaultOrderNumber());
        }
        return $this->orderNumber;
    }

    /**
     * Check if order number has been set
     *
     * @return bool True if order number has been set, false if not
     */
    public function hasOrderNumber(): bool
    {
        return isset($this->orderNumber);
    }

    /**
     * Get a default order number value, if any is available
     *
     * @return int|null Default order number value or null if no default value is available
     */
    public function getDefaultOrderNumber(): int|null
    {
        return null;
    }
}
