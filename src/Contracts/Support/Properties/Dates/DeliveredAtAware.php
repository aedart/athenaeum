<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Delivered at Aware
 *
 * Component is aware of \DateTimeInterface "delivered at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface DeliveredAtAware
{
    /**
     * Set delivered at
     *
     * @param \DateTimeInterface|null $date Date of delivery
     *
     * @return self
     */
    public function setDeliveredAt(?\DateTimeInterface $date);

    /**
     * Get delivered at
     *
     * If no "delivered at" value set, method
     * sets and returns a default "delivered at".
     *
     * @see getDefaultDeliveredAt()
     *
     * @return \DateTimeInterface|null delivered at or null if no delivered at has been set
     */
    public function getDeliveredAt() : ?\DateTimeInterface;

    /**
     * Check if "delivered at" has been set
     *
     * @return bool True if "delivered at" has been set, false if not
     */
    public function hasDeliveredAt() : bool;

    /**
     * Get a default "delivered at" value, if any is available
     *
     * @return \DateTimeInterface|null Default "delivered at" value or null if no default value is available
     */
    public function getDefaultDeliveredAt() : ?\DateTimeInterface;
}
