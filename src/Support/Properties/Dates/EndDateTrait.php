<?php

namespace Aedart\Support\Properties\Dates;

/**
 * End date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\EndDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait EndDateTrait
{
    /**
     * Date for when some kind of event ends
     *
     * @var \DateTime|null
     */
    protected $endDate = null;

    /**
     * Set end date
     *
     * @param \DateTime|null $date Date for when some kind of event ends
     *
     * @return self
     */
    public function setEndDate(?\DateTime $date)
    {
        $this->endDate = $date;

        return $this;
    }

    /**
     * Get end date
     *
     * If no "end date" value set, method
     * sets and returns a default "end date".
     *
     * @see getDefaultEndDate()
     *
     * @return \DateTime|null end date or null if no end date has been set
     */
    public function getEndDate() : ?\DateTime
    {
        if ( ! $this->hasEndDate()) {
            $this->setEndDate($this->getDefaultEndDate());
        }
        return $this->endDate;
    }

    /**
     * Check if "end date" has been set
     *
     * @return bool True if "end date" has been set, false if not
     */
    public function hasEndDate() : bool
    {
        return isset($this->endDate);
    }

    /**
     * Get a default "end date" value, if any is available
     *
     * @return \DateTime|null Default "end date" value or null if no default value is available
     */
    public function getDefaultEndDate() : ?\DateTime
    {
        return null;
    }
}
