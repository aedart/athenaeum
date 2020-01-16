<?php

namespace Aedart\Support\Properties\Dates;

/**
 * Date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\DateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait DateTrait
{
    /**
     * Date of event
     *
     * @var \DateTime|null
     */
    protected ?\DateTime $date = null;

    /**
     * Set date
     *
     * @param \DateTime|null $date Date of event
     *
     * @return self
     */
    public function setDate(?\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * If no "date" value set, method
     * sets and returns a default "date".
     *
     * @see getDefaultDate()
     *
     * @return \DateTime|null date or null if no date has been set
     */
    public function getDate() : ?\DateTime
    {
        if ( ! $this->hasDate()) {
            $this->setDate($this->getDefaultDate());
        }
        return $this->date;
    }

    /**
     * Check if "date" has been set
     *
     * @return bool True if "date" has been set, false if not
     */
    public function hasDate() : bool
    {
        return isset($this->date);
    }

    /**
     * Get a default "date" value, if any is available
     *
     * @return \DateTime|null Default "date" value or null if no default value is available
     */
    public function getDefaultDate() : ?\DateTime
    {
        return null;
    }
}
