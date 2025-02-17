<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Birthdate Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\BirthdateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait BirthdateTrait
{
    /**
     * Date of birth
     *
     * @var int|null
     */
    protected int|null $birthdate = null;

    /**
     * Set birthdate
     *
     * @param int|null $date Date of birth
     *
     * @return self
     */
    public function setBirthdate(int|null $date): static
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
     * @return int|null birthdate or null if no birthdate has been set
     */
    public function getBirthdate(): int|null
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
     * @return int|null Default birthdate value or null if no default value is available
     */
    public function getDefaultBirthdate(): int|null
    {
        return null;
    }
}
