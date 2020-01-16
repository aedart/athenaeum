<?php

namespace Aedart\Support\Properties\Floats;

/**
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
    protected ?float $quantity = null;

    /**
     * Set quantity
     *
     * @param float|null $quantity The quantity of something
     *
     * @return self
     */
    public function setQuantity(?float $quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * If no "quantity" value set, method
     * sets and returns a default "quantity".
     *
     * @see getDefaultQuantity()
     *
     * @return float|null quantity or null if no quantity has been set
     */
    public function getQuantity() : ?float
    {
        if ( ! $this->hasQuantity()) {
            $this->setQuantity($this->getDefaultQuantity());
        }
        return $this->quantity;
    }

    /**
     * Check if "quantity" has been set
     *
     * @return bool True if "quantity" has been set, false if not
     */
    public function hasQuantity() : bool
    {
        return isset($this->quantity);
    }

    /**
     * Get a default "quantity" value, if any is available
     *
     * @return float|null Default "quantity" value or null if no default value is available
     */
    public function getDefaultQuantity() : ?float
    {
        return null;
    }
}
