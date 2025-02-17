<?php

namespace Aedart\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
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
     * @var \DateTimeInterface|null
     */
    protected \DateTimeInterface|null $birthdate = null;

    /**
     * Set birthdate
     *
     * @param \DateTimeInterface|null $date Date of birth
     *
     * @return self
     */
    public function setBirthdate(\DateTimeInterface|null $date): static
    {
        $this->birthdate = $date;

        return $this;
    }

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
    public function getBirthdate(): \DateTimeInterface|null
    {
        if (!$this->hasBirthdate()) {
            $this->setBirthdate($this->getDefaultBirthdate());
        }
        return $this->birthdate;
    }

    /**
     * Check if birthdate has been set
     *
     * @return bool True if birthdate has been set, false if not
     */
    public function hasBirthdate(): bool
    {
        return isset($this->birthdate);
    }

    /**
     * Get a default birthdate value, if any is available
     *
     * @return \DateTimeInterface|null Default birthdate value or null if no default value is available
     */
    public function getDefaultBirthdate(): \DateTimeInterface|null
    {
        return null;
    }
}
