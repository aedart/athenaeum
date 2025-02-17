<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Quantity Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\QuantityAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait QuantityTrait
{
    /**
     * The quantity of something
     *
     * @var int|null
     */
    protected int|null $quantity = null;

    /**
     * Set quantity
     *
     * @param int|null $quantity The quantity of something
     *
     * @return self
     */
    public function setQuantity(int|null $quantity): static
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
     * @return int|null quantity or null if no quantity has been set
     */
    public function getQuantity(): int|null
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
     * @return int|null Default quantity value or null if no default value is available
     */
    public function getDefaultQuantity(): int|null
    {
        return null;
    }
}
