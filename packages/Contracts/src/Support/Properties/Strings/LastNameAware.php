<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Last name Aware
 *
 * Component is aware of string "last name"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface LastNameAware
{
    /**
     * Set last name
     *
     * @param string|null $name Last Name (surname) or family name of a person
     *
     * @return self
     */
    public function setLastName(string|null $name): static;

    /**
     * Get last name
     *
     * If no last name value set, method
     * sets and returns a default last name.
     *
     * @see getDefaultLastName()
     *
     * @return string|null last name or null if no last name has been set
     */
    public function getLastName(): string|null;

    /**
     * Check if last name has been set
     *
     * @return bool True if last name has been set, false if not
     */
    public function hasLastName(): bool;

    /**
     * Get a default last name value, if any is available
     *
     * @return string|null Default last name value or null if no default value is available
     */
    public function getDefaultLastName(): string|null;
}
