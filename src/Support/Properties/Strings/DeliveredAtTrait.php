<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Delivered at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DeliveredAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DeliveredAtTrait
{
    /**
     * Date of delivery
     *
     * @var string|null
     */
    protected $deliveredAt = null;

    /**
     * Set delivered at
     *
     * @param string|null $date Date of delivery
     *
     * @return self
     */
    public function setDeliveredAt(?string $date)
    {
        $this->deliveredAt = $date;

        return $this;
    }

    /**
     * Get delivered at
     *
     * If no "delivered at" value set, method
     * sets and returns a default "delivered at".
     *
     * @see getDefaultDeliveredAt()
     *
     * @return string|null delivered at or null if no delivered at has been set
     */
    public function getDeliveredAt() : ?string
    {
        if ( ! $this->hasDeliveredAt()) {
            $this->setDeliveredAt($this->getDefaultDeliveredAt());
        }
        return $this->deliveredAt;
    }

    /**
     * Check if "delivered at" has been set
     *
     * @return bool True if "delivered at" has been set, false if not
     */
    public function hasDeliveredAt() : bool
    {
        return isset($this->deliveredAt);
    }

    /**
     * Get a default "delivered at" value, if any is available
     *
     * @return string|null Default "delivered at" value or null if no default value is available
     */
    public function getDefaultDeliveredAt() : ?string
    {
        return null;
    }
}
