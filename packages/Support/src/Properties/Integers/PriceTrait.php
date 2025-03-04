<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Price Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\PriceAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait PriceTrait
{
    /**
     * Numeric price
     *
     * @var int|null
     */
    protected int|null $price = null;

    /**
     * Set price
     *
     * @param int|null $amount Numeric price
     *
     * @return self
     */
    public function setPrice(int|null $amount): static
    {
        $this->price = $amount;

        return $this;
    }

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
    public function getPrice(): int|null
    {
        if (!$this->hasPrice()) {
            $this->setPrice($this->getDefaultPrice());
        }
        return $this->price;
    }

    /**
     * Check if price has been set
     *
     * @return bool True if price has been set, false if not
     */
    public function hasPrice(): bool
    {
        return isset($this->price);
    }

    /**
     * Get a default price value, if any is available
     *
     * @return int|null Default price value or null if no default value is available
     */
    public function getDefaultPrice(): int|null
    {
        return null;
    }
}
