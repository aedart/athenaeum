<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Delivery date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DeliveryDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DeliveryDateTrait
{
    /**
     * Date of planned delivery
     *
     * @var string|null
     */
    protected string|null $deliveryDate = null;

    /**
     * Set delivery date
     *
     * @param string|null $date Date of planned delivery
     *
     * @return self
     */
    public function setDeliveryDate(string|null $date): static
    {
        $this->deliveryDate = $date;

        return $this;
    }

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
    public function getDeliveryDate(): string|null
    {
        if (!$this->hasDeliveryDate()) {
            $this->setDeliveryDate($this->getDefaultDeliveryDate());
        }
        return $this->deliveryDate;
    }

    /**
     * Check if delivery date has been set
     *
     * @return bool True if delivery date has been set, false if not
     */
    public function hasDeliveryDate(): bool
    {
        return isset($this->deliveryDate);
    }

    /**
     * Get a default delivery date value, if any is available
     *
     * @return string|null Default delivery date value or null if no default value is available
     */
    public function getDefaultDeliveryDate(): string|null
    {
        return null;
    }
}
