<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Discount Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DiscountAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DiscountTrait
{
    /**
     * Discount amount
     *
     * @var string|null
     */
    protected string|null $discount = null;

    /**
     * Set discount
     *
     * @param string|null $amount Discount amount
     *
     * @return self
     */
    public function setDiscount(string|null $amount): static
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
     * @return string|null discount or null if no discount has been set
     */
    public function getDiscount(): string|null
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
     * @return string|null Default discount value or null if no default value is available
     */
    public function getDefaultDiscount(): string|null
    {
        return null;
    }
}
