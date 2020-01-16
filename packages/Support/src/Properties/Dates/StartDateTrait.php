<?php

namespace Aedart\Support\Properties\Dates;

/**
 * Start date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\StartDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait StartDateTrait
{
    /**
     * Start date of event
     *
     * @var \DateTime|null
     */
    protected ?\DateTime $startDate = null;

    /**
     * Set start date
     *
     * @param \DateTime|null $date Start date of event
     *
     * @return self
     */
    public function setStartDate(?\DateTime $date)
    {
        $this->startDate = $date;

        return $this;
    }

    /**
     * Get start date
     *
     * If no "start date" value set, method
     * sets and returns a default "start date".
     *
     * @see getDefaultStartDate()
     *
     * @return \DateTime|null start date or null if no start date has been set
     */
    public function getStartDate() : ?\DateTime
    {
        if ( ! $this->hasStartDate()) {
            $this->setStartDate($this->getDefaultStartDate());
        }
        return $this->startDate;
    }

    /**
     * Check if "start date" has been set
     *
     * @return bool True if "start date" has been set, false if not
     */
    public function hasStartDate() : bool
    {
        return isset($this->startDate);
    }

    /**
     * Get a default "start date" value, if any is available
     *
     * @return \DateTime|null Default "start date" value or null if no default value is available
     */
    public function getDefaultStartDate() : ?\DateTime
    {
        return null;
    }
}
