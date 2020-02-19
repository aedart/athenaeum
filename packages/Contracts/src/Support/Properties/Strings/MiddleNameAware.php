<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Middle name Aware
 *
 * Component is aware of string "middle name"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface MiddleNameAware
{
    /**
     * Set middle name
     *
     * @param string|null $name Middle Name or names of a person
     *
     * @return self
     */
    public function setMiddleName(?string $name);

    /**
     * Get middle name
     *
     * If no "middle name" value set, method
     * sets and returns a default "middle name".
     *
     * @see getDefaultMiddleName()
     *
     * @return string|null middle name or null if no middle name has been set
     */
    public function getMiddleName(): ?string;

    /**
     * Check if "middle name" has been set
     *
     * @return bool True if "middle name" has been set, false if not
     */
    public function hasMiddleName(): bool;

    /**
     * Get a default "middle name" value, if any is available
     *
     * @return string|null Default "middle name" value or null if no default value is available
     */
    public function getDefaultMiddleName(): ?string;
}
