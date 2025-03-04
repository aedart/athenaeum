<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Delivered at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\DeliveredAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait DeliveredAtTrait
{
    /**
     * Date of delivery
     *
     * @var int|null
     */
    protected int|null $deliveredAt = null;

    /**
     * Set delivered at
     *
     * @param int|null $date Date of delivery
     *
     * @return self
     */
    public function setDeliveredAt(int|null $date): static
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
     * @return int|null delivered at or null if no delivered at has been set
     */
    public function getDeliveredAt(): int|null
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
     * @return int|null Default delivered at value or null if no default value is available
     */
    public function getDefaultDeliveredAt(): int|null
    {
        return null;
    }
}
