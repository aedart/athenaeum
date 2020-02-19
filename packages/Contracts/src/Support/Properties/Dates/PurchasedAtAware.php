<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Purchased at Aware
 *
 * Component is aware of \DateTime "purchased at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface PurchasedAtAware
{
    /**
     * Set purchased at
     *
     * @param \DateTime|null $date Date of when this component, entity or resource was purchased
     *
     * @return self
     */
    public function setPurchasedAt(?\DateTime $date);

    /**
     * Get purchased at
     *
     * If no "purchased at" value set, method
     * sets and returns a default "purchased at".
     *
     * @see getDefaultPurchasedAt()
     *
     * @return \DateTime|null purchased at or null if no purchased at has been set
     */
    public function getPurchasedAt(): ?\DateTime;

    /**
     * Check if "purchased at" has been set
     *
     * @return bool True if "purchased at" has been set, false if not
     */
    public function hasPurchasedAt(): bool;

    /**
     * Get a default "purchased at" value, if any is available
     *
     * @return \DateTime|null Default "purchased at" value or null if no default value is available
     */
    public function getDefaultPurchasedAt(): ?\DateTime;
}
