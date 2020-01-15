<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Birthdate Aware
 *
 * Component is aware of \DateTime "birthdate"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface BirthdateAware
{
    /**
     * Set birthdate
     *
     * @param \DateTime|null $date Date of birth
     *
     * @return self
     */
    public function setBirthdate(?\DateTime $date);

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
    public function getBirthdate() : ?\DateTime;

    /**
     * Check if "birthdate" has been set
     *
     * @return bool True if "birthdate" has been set, false if not
     */
    public function hasBirthdate() : bool;

    /**
     * Get a default "birthdate" value, if any is available
     *
     * @return \DateTime|null Default "birthdate" value or null if no default value is available
     */
    public function getDefaultBirthdate() : ?\DateTime;
}
