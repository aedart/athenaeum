<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * First name Aware
 *
 * Component is aware of string "first name"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface FirstNameAware
{
    /**
     * Set first name
     *
     * @param string|null $name First name (given name) or forename of a person
     *
     * @return self
     */
    public function setFirstName(string|null $name): static;

    /**
     * Get first name
     *
     * If no first name value set, method
     * sets and returns a default first name.
     *
     * @see getDefaultFirstName()
     *
     * @return string|null first name or null if no first name has been set
     */
    public function getFirstName(): string|null;

    /**
     * Check if first name has been set
     *
     * @return bool True if first name has been set, false if not
     */
    public function hasFirstName(): bool;

    /**
     * Get a default first name value, if any is available
     *
     * @return string|null Default first name value or null if no default value is available
     */
    public function getDefaultFirstName(): string|null;
}
