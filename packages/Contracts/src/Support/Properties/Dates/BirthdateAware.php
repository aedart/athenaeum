<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Birthdate Aware
 *
 * Component is aware of \DateTimeInterface "birthdate"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface BirthdateAware
{
    /**
     * Set birthdate
     *
     * @param \DateTimeInterface|null $date Date of birth
     *
     * @return self
     */
    public function setBirthdate(\DateTimeInterface|null $date): static;

    /**
     * Get birthdate
     *
     * If no birthdate value set, method
     * sets and returns a default birthdate.
     *
     * @see getDefaultBirthdate()
     *
     * @return \DateTimeInterface|null birthdate or null if no birthdate has been set
     */
    public function getBirthdate(): \DateTimeInterface|null;

    /**
     * Check if birthdate has been set
     *
     * @return bool True if birthdate has been set, false if not
     */
    public function hasBirthdate(): bool;

    /**
     * Get a default birthdate value, if any is available
     *
     * @return \DateTimeInterface|null Default birthdate value or null if no default value is available
     */
    public function getDefaultBirthdate(): \DateTimeInterface|null;
}
