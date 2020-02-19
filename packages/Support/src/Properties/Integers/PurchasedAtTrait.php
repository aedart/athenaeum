<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Purchased at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\PurchasedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait PurchasedAtTrait
{
    /**
     * Date of when this component, entity or resource was purchased
     *
     * @var int|null
     */
    protected ?int $purchasedAt = null;

    /**
     * Set purchased at
     *
     * @param int|null $date Date of when this component, entity or resource was purchased
     *
     * @return self
     */
    public function setPurchasedAt(?int $date)
    {
        $this->purchasedAt = $date;

        return $this;
    }

    /**
     * Get purchased at
     *
     * If no "purchased at" value set, method
     * sets and returns a default "purchased at".
     *
     * @see getDefaultPurchasedAt()
     *
     * @return int|null purchased at or null if no purchased at has been set
     */
    public function getPurchasedAt(): ?int
    {
        if (!$this->hasPurchasedAt()) {
            $this->setPurchasedAt($this->getDefaultPurchasedAt());
        }
        return $this->purchasedAt;
    }

    /**
     * Check if "purchased at" has been set
     *
     * @return bool True if "purchased at" has been set, false if not
     */
    public function hasPurchasedAt(): bool
    {
        return isset($this->purchasedAt);
    }

    /**
     * Get a default "purchased at" value, if any is available
     *
     * @return int|null Default "purchased at" value or null if no default value is available
     */
    public function getDefaultPurchasedAt(): ?int
    {
        return null;
    }
}
