<?php

namespace Aedart\Support\Properties\Dates;

/**
 * Produced at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\ProducedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait ProducedAtTrait
{
    /**
     * Date of when this component, entity or something was produced
     *
     * @var \DateTime|null
     */
    protected $producedAt = null;

    /**
     * Set produced at
     *
     * @param \DateTime|null $date Date of when this component, entity or something was produced
     *
     * @return self
     */
    public function setProducedAt(?\DateTime $date)
    {
        $this->producedAt = $date;

        return $this;
    }

    /**
     * Get produced at
     *
     * If no "produced at" value set, method
     * sets and returns a default "produced at".
     *
     * @see getDefaultProducedAt()
     *
     * @return \DateTime|null produced at or null if no produced at has been set
     */
    public function getProducedAt() : ?\DateTime
    {
        if ( ! $this->hasProducedAt()) {
            $this->setProducedAt($this->getDefaultProducedAt());
        }
        return $this->producedAt;
    }

    /**
     * Check if "produced at" has been set
     *
     * @return bool True if "produced at" has been set, false if not
     */
    public function hasProducedAt() : bool
    {
        return isset($this->producedAt);
    }

    /**
     * Get a default "produced at" value, if any is available
     *
     * @return \DateTime|null Default "produced at" value or null if no default value is available
     */
    public function getDefaultProducedAt() : ?\DateTime
    {
        return null;
    }
}
