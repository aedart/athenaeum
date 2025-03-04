<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Discount Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\DiscountAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait DiscountTrait
{
    /**
     * Discount amount
     *
     * @var float|null
     */
    protected float|null $discount = null;

    /**
     * Set discount
     *
     * @param float|null $amount Discount amount
     *
     * @return self
     */
    public function setDiscount(float|null $amount): static
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
     * @return float|null discount or null if no discount has been set
     */
    public function getDiscount(): float|null
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
     * @return float|null Default discount value or null if no default value is available
     */
    public function getDefaultDiscount(): float|null
    {
        return null;
    }
}
