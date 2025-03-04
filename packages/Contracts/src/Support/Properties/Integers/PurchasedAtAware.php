<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Purchased at Aware
 *
 * Component is aware of int "purchased at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface PurchasedAtAware
{
    /**
     * Set purchased at
     *
     * @param int|null $date Date of when this component, entity or resource was purchased
     *
     * @return self
     */
    public function setPurchasedAt(int|null $date): static;

    /**
     * Get purchased at
     *
     * If no purchased at value set, method
     * sets and returns a default purchased at.
     *
     * @see getDefaultPurchasedAt()
     *
     * @return int|null purchased at or null if no purchased at has been set
     */
    public function getPurchasedAt(): int|null;

    /**
     * Check if purchased at has been set
     *
     * @return bool True if purchased at has been set, false if not
     */
    public function hasPurchasedAt(): bool;

    /**
     * Get a default purchased at value, if any is available
     *
     * @return int|null Default purchased at value or null if no default value is available
     */
    public function getDefaultPurchasedAt(): int|null;
}
