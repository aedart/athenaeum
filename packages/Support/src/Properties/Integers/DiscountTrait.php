<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Discount Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\DiscountAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait DiscountTrait
{
    /**
     * Discount amount
     *
     * @var int|null
     */
    protected int|null $discount = null;

    /**
     * Set discount
     *
     * @param int|null $amount Discount amount
     *
     * @return self
     */
    public function setDiscount(int|null $amount): static
    {
        $this->discount = $amount;

        return $this;
    }

    /**
     * Get discount
     *
     * If no discount value set, method
     * sets and returns a default discount.
     *
     * @see getDefaultDiscount()
     *
     * @return int|null discount or null if no discount has been set
     */
    public function getDiscount(): int|null
    {
        if (!$this->hasDiscount()) {
            $this->setDiscount($this->getDefaultDiscount());
        }
        return $this->discount;
    }

    /**
     * Check if discount has been set
     *
     * @return bool True if discount has been set, false if not
     */
    public function hasDiscount(): bool
    {
        return isset($this->discount);
    }

    /**
     * Get a default discount value, if any is available
     *
     * @return int|null Default discount value or null if no default value is available
     */
    public function getDefaultDiscount(): int|null
    {
        return null;
    }
}
