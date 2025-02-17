<?php

namespace Aedart\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Delivered at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\DeliveredAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait DeliveredAtTrait
{
    /**
     * Date of delivery
     *
     * @var \DateTimeInterface|null
     */
    protected \DateTimeInterface|null $deliveredAt = null;

    /**
     * Set delivered at
     *
     * @param \DateTimeInterface|null $date Date of delivery
     *
     * @return self
     */
    public function setDeliveredAt(\DateTimeInterface|null $date): static
    {
        $this->deliveredAt = $date;

        return $this;
    }

    /**
     * Get delivered at
     *
     * If no delivered at value set, method
     * sets and returns a default delivered at.
     *
     * @see getDefaultDeliveredAt()
     *
     * @return \DateTimeInterface|null delivered at or null if no delivered at has been set
     */
    public function getDeliveredAt(): \DateTimeInterface|null
    {
        if (!$this->hasDeliveredAt()) {
            $this->setDeliveredAt($this->getDefaultDeliveredAt());
        }
        return $this->deliveredAt;
    }

    /**
     * Check if delivered at has been set
     *
     * @return bool True if delivered at has been set, false if not
     */
    public function hasDeliveredAt(): bool
    {
        return isset($this->deliveredAt);
    }

    /**
     * Get a default delivered at value, if any is available
     *
     * @return \DateTimeInterface|null Default delivered at value or null if no default value is available
     */
    public function getDefaultDeliveredAt(): \DateTimeInterface|null
    {
        return null;
    }
}
