<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Delivery date Aware
 *
 * Component is aware of string "delivery date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface DeliveryDateAware
{
    /**
     * Set delivery date
     *
     * @param string|null $date Date of planned delivery
     *
     * @return self
     */
    public function setDeliveryDate(string|null $date): static;

    /**
     * Get delivery date
     *
     * If no delivery date value set, method
     * sets and returns a default delivery date.
     *
     * @see getDefaultDeliveryDate()
     *
     * @return string|null delivery date or null if no delivery date has been set
     */
    public function getDeliveryDate(): string|null;

    /**
     * Check if delivery date has been set
     *
     * @return bool True if delivery date has been set, false if not
     */
    public function hasDeliveryDate(): bool;

    /**
     * Get a default delivery date value, if any is available
     *
     * @return string|null Default delivery date value or null if no default value is available
     */
    public function getDefaultDeliveryDate(): string|null;
}
