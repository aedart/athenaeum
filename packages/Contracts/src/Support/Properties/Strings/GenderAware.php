<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Gender Aware
 *
 * Component is aware of string "gender"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface GenderAware
{
    /**
     * Set gender
     *
     * @param string|null $identity Gender (sex) identity of a person, animal or something
     *
     * @return self
     */
    public function setGender(string|null $identity): static;

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
    public function getGender(): string|null;

    /**
     * Check if gender has been set
     *
     * @return bool True if gender has been set, false if not
     */
    public function hasGender(): bool;

    /**
     * Get a default gender value, if any is available
     *
     * @return string|null Default gender value or null if no default value is available
     */
    public function getDefaultGender(): string|null;
}
