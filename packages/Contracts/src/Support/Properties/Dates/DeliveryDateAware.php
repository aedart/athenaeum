<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Delivery date Aware
 *
 * Component is aware of \DateTime "delivery date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface DeliveryDateAware
{
    /**
     * Set delivery date
     *
     * @param \DateTime|null $date Date of planned delivery
     *
     * @return self
     */
    public function setDeliveryDate(?\DateTime $date);

    /**
     * Get delivery date
     *
     * If no "delivery date" value set, method
     * sets and returns a default "delivery date".
     *
     * @see getDefaultDeliveryDate()
     *
     * @return \DateTime|null delivery date or null if no delivery date has been set
     */
    public function getDeliveryDate(): ?\DateTime;

    /**
     * Check if "delivery date" has been set
     *
     * @return bool True if "delivery date" has been set, false if not
     */
    public function hasDeliveryDate(): bool;

    /**
     * Get a default "delivery date" value, if any is available
     *
     * @return \DateTime|null Default "delivery date" value or null if no default value is available
     */
    public function getDefaultDeliveryDate(): ?\DateTime;
}
