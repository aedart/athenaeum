<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * Delivered at Aware
 *
 * Component is aware of int "delivered at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface DeliveredAtAware
{
    /**
     * Set delivered at
     *
     * @param int|null $date Date of delivery
     *
     * @return self
     */
    public function setDeliveredAt(?int $date);

    /**
     * Get delivered at
     *
     * If no "delivered at" value set, method
     * sets and returns a default "delivered at".
     *
     * @see getDefaultDeliveredAt()
     *
     * @return int|null delivered at or null if no delivered at has been set
     */
    public function getDeliveredAt(): ?int;

    /**
     * Check if "delivered at" has been set
     *
     * @return bool True if "delivered at" has been set, false if not
     */
    public function hasDeliveredAt(): bool;

    /**
     * Get a default "delivered at" value, if any is available
     *
     * @return int|null Default "delivered at" value or null if no default value is available
     */
    public function getDefaultDeliveredAt(): ?int;
}
