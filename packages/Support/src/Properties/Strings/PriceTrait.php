<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Price Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\PriceAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait PriceTrait
{
    /**
     * Numeric price
     *
     * @var string|null
     */
    protected string|null $price = null;

    /**
     * Set price
     *
     * @param string|null $amount Numeric price
     *
     * @return self
     */
    public function setPrice(string|null $amount): static
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
     * @return string|null price or null if no price has been set
     */
    public function getPrice(): string|null
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
     * @return string|null Default price value or null if no default value is available
     */
    public function getDefaultPrice(): string|null
    {
        return null;
    }
}
