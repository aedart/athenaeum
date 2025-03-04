<?php

namespace Aedart\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
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
     * @var \DateTimeInterface|null
     */
    protected \DateTimeInterface|null $purchasedAt = null;

    /**
     * Set purchased at
     *
     * @param \DateTimeInterface|null $date Date of when this component, entity or resource was purchased
     *
     * @return self
     */
    public function setPurchasedAt(\DateTimeInterface|null $date): static
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
     * @return \DateTimeInterface|null purchased at or null if no purchased at has been set
     */
    public function getPurchasedAt(): \DateTimeInterface|null
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
     * @return \DateTimeInterface|null Default purchased at value or null if no default value is available
     */
    public function getDefaultPurchasedAt(): \DateTimeInterface|null
    {
        return null;
    }
}
