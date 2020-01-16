<?php

namespace Aedart\Support\Properties\Integers;

/**
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
    protected ?int $birthdate = null;

    /**
     * Set birthdate
     *
     * @param int|null $date Date of birth
     *
     * @return self
     */
    public function setBirthdate(?int $date)
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
     * @return int|null birthdate or null if no birthdate has been set
     */
    public function getBirthdate() : ?int
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
     * @return int|null Default "birthdate" value or null if no default value is available
     */
    public function getDefaultBirthdate() : ?int
    {
        return null;
    }
}
