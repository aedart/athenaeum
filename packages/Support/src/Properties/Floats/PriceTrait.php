<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Price Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\PriceAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait PriceTrait
{
    /**
     * Numeric price
     *
     * @var float|null
     */
    protected float|null $price = null;

    /**
     * Set price
     *
     * @param float|null $amount Numeric price
     *
     * @return self
     */
    public function setPrice(float|null $amount): static
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
     * @return float|null price or null if no price has been set
     */
    public function getPrice(): float|null
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
     * @return float|null Default price value or null if no default value is available
     */
    public function getDefaultPrice(): float|null
    {
        return null;
    }
}
