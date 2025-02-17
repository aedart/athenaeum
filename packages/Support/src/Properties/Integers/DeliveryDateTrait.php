<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Delivery date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\DeliveryDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait DeliveryDateTrait
{
    /**
     * Date of planned delivery
     *
     * @var int|null
     */
    protected int|null $deliveryDate = null;

    /**
     * Set delivery date
     *
     * @param int|null $date Date of planned delivery
     *
     * @return self
     */
    public function setDeliveryDate(int|null $date): static
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
     * @return int|null delivery date or null if no delivery date has been set
     */
    public function getDeliveryDate(): int|null
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
     * @return int|null Default delivery date value or null if no default value is available
     */
    public function getDefaultDeliveryDate(): int|null
    {
        return null;
    }
}
