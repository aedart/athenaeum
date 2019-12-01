<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Order number Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\OrderNumberAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait OrderNumberTrait
{
    /**
     * Number that represents a purchase or order placed by a customer
     *
     * @var string|null
     */
    protected ?string $orderNumber = null;

    /**
     * Set order number
     *
     * @param string|null $number Number that represents a purchase or order placed by a customer
     *
     * @return self
     */
    public function setOrderNumber(?string $number)
    {
        $this->orderNumber = $number;

        return $this;
    }

    /**
     * Get order number
     *
     * If no "order number" value set, method
     * sets and returns a default "order number".
     *
     * @see getDefaultOrderNumber()
     *
     * @return string|null order number or null if no order number has been set
     */
    public function getOrderNumber() : ?string
    {
        if ( ! $this->hasOrderNumber()) {
            $this->setOrderNumber($this->getDefaultOrderNumber());
        }
        return $this->orderNumber;
    }

    /**
     * Check if "order number" has been set
     *
     * @return bool True if "order number" has been set, false if not
     */
    public function hasOrderNumber() : bool
    {
        return isset($this->orderNumber);
    }

    /**
     * Get a default "order number" value, if any is available
     *
     * @return string|null Default "order number" value or null if no default value is available
     */
    public function getDefaultOrderNumber() : ?string
    {
        return null;
    }
}
