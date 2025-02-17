<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Birthdate Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\BirthdateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait BirthdateTrait
{
    /**
     * Date of birth
     *
     * @var string|null
     */
    protected string|null $birthdate = null;

    /**
     * Set birthdate
     *
     * @param string|null $date Date of birth
     *
     * @return self
     */
    public function setBirthdate(string|null $date): static
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
     * @return string|null birthdate or null if no birthdate has been set
     */
    public function getBirthdate(): string|null
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
     * @return string|null Default birthdate value or null if no default value is available
     */
    public function getDefaultBirthdate(): string|null
    {
        return null;
    }
}
