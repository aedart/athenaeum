<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Quantity Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\QuantityAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait QuantityTrait
{
    /**
     * The quantity of something
     *
     * @var float|null
     */
    protected float|null $quantity = null;

    /**
     * Set quantity
     *
     * @param float|null $quantity The quantity of something
     *
     * @return self
     */
    public function setQuantity(float|null $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * If no quantity value set, method
     * sets and returns a default quantity.
     *
     * @see getDefaultQuantity()
     *
     * @return float|null quantity or null if no quantity has been set
     */
    public function getQuantity(): float|null
    {
        if (!$this->hasQuantity()) {
            $this->setQuantity($this->getDefaultQuantity());
        }
        return $this->quantity;
    }

    /**
     * Check if quantity has been set
     *
     * @return bool True if quantity has been set, false if not
     */
    public function hasQuantity(): bool
    {
        return isset($this->quantity);
    }

    /**
     * Get a default quantity value, if any is available
     *
     * @return float|null Default quantity value or null if no default value is available
     */
    public function getDefaultQuantity(): float|null
    {
        return null;
    }
}
