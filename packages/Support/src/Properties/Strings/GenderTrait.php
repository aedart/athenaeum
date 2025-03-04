<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Gender Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\GenderAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait GenderTrait
{
    /**
     * Gender (sex) identity of a person, animal or something
     *
     * @var string|null
     */
    protected string|null $gender = null;

    /**
     * Set gender
     *
     * @param string|null $identity Gender (sex) identity of a person, animal or something
     *
     * @return self
     */
    public function setGender(string|null $identity): static
    {
        $this->gender = $identity;

        return $this;
    }

    /**
     * Get gender
     *
     * If no gender value set, method
     * sets and returns a default gender.
     *
     * @see getDefaultGender()
     *
     * @return string|null gender or null if no gender has been set
     */
    public function getGender(): string|null
    {
        if (!$this->hasGender()) {
            $this->setGender($this->getDefaultGender());
        }
        return $this->gender;
    }

    /**
     * Check if gender has been set
     *
     * @return bool True if gender has been set, false if not
     */
    public function hasGender(): bool
    {
        return isset($this->gender);
    }

    /**
     * Get a default gender value, if any is available
     *
     * @return string|null Default gender value or null if no default value is available
     */
    public function getDefaultGender(): string|null
    {
        return null;
    }
}
