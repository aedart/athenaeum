<?php

namespace Aedart\Support\Properties\Dates;

/**
 * Birthdate Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\BirthdateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait BirthdateTrait
{
    /**
     * Date of birth
     *
     * @var \DateTime|null
     */
    protected $birthdate = null;

    /**
     * Set birthdate
     *
     * @param \DateTime|null $date Date of birth
     *
     * @return self
     */
    public function setBirthdate(?\DateTime $date)
    {
        $this->birthdate = $date;

        return $this;
    }

    /**
     * Get birthdate
     *
     * If no "birthdate" value set, method
     * sets and returns a default "birthdate".
     *
     * @see getDefaultBirthdate()
     *
     * @return \DateTime|null birthdate or null if no birthdate has been set
     */
    public function getBirthdate() : ?\DateTime
    {
        if ( ! $this->hasBirthdate()) {
            $this->setBirthdate($this->getDefaultBirthdate());
        }
        return $this->birthdate;
    }

    /**
     * Check if "birthdate" has been set
     *
     * @return bool True if "birthdate" has been set, false if not
     */
    public function hasBirthdate() : bool
    {
        return isset($this->birthdate);
    }

    /**
     * Get a default "birthdate" value, if any is available
     *
     * @return \DateTime|null Default "birthdate" value or null if no default value is available
     */
    public function getDefaultBirthdate() : ?\DateTime
    {
        return null;
    }
}
