<?php

namespace Aedart\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Delivery date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\DeliveryDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait DeliveryDateTrait
{
    /**
     * Date of planned delivery
     *
     * @var \DateTimeInterface|null
     */
    protected \DateTimeInterface|null $deliveryDate = null;

    /**
     * Set delivery date
     *
     * @param \DateTimeInterface|null $date Date of planned delivery
     *
     * @return self
     */
    public function setDeliveryDate(\DateTimeInterface|null $date): static
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
     * @return \DateTimeInterface|null delivery date or null if no delivery date has been set
     */
    public function getDeliveryDate(): \DateTimeInterface|null
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
     * @return \DateTimeInterface|null Default delivery date value or null if no default value is available
     */
    public function getDefaultDeliveryDate(): \DateTimeInterface|null
    {
        return null;
    }
}
