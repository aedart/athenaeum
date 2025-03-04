<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Purchased at Aware
 *
 * Component is aware of \DateTimeInterface "purchased at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface PurchasedAtAware
{
    /**
     * Set purchased at
     *
     * @param \DateTimeInterface|null $date Date of when this component, entity or resource was purchased
     *
     * @return self
     */
    public function setPurchasedAt(\DateTimeInterface|null $date): static;

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
    public function getPurchasedAt(): \DateTimeInterface|null;

    /**
     * Check if purchased at has been set
     *
     * @return bool True if purchased at has been set, false if not
     */
    public function hasPurchasedAt(): bool;

    /**
     * Get a default purchased at value, if any is available
     *
     * @return \DateTimeInterface|null Default purchased at value or null if no default value is available
     */
    public function getDefaultPurchasedAt(): \DateTimeInterface|null;
}
