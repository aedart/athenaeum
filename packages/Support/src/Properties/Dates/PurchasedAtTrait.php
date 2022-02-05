<?php

namespace Aedart\Support\Properties\Dates;

/**
 * Purchased at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\PurchasedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait PurchasedAtTrait
{
    /**
     * Date of when this component, entity or resource was purchased
     *
     * @var \DateTime|null
     */
    protected \DateTime|null $purchasedAt = null;

    /**
     * Set purchased at
     *
     * @param \DateTime|null $date Date of when this component, entity or resource was purchased
     *
     * @return self
     */
    public function setPurchasedAt(\DateTime|null $date): static
    {
        $this->purchasedAt = $date;

        return $this;
    }

    /**
     * Get purchased at
     *
     * If no purchased at value set, method
     * sets and returns a default purchased at.
     *
     * @see getDefaultPurchasedAt()
     *
     * @return \DateTime|null purchased at or null if no purchased at has been set
     */
    public function getPurchasedAt(): \DateTime|null
    {
        if (!$this->hasPurchasedAt()) {
            $this->setPurchasedAt($this->getDefaultPurchasedAt());
        }
        return $this->purchasedAt;
    }

    /**
     * Check if purchased at has been set
     *
     * @return bool True if purchased at has been set, false if not
     */
    public function hasPurchasedAt(): bool
    {
        return isset($this->purchasedAt);
    }

    /**
     * Get a default purchased at value, if any is available
     *
     * @return \DateTime|null Default purchased at value or null if no default value is available
     */
    public function getDefaultPurchasedAt(): \DateTime|null
    {
        return null;
    }
}
