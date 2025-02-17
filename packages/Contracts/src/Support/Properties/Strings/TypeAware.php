<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Type Aware
 *
 * Component is aware of string "type"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface TypeAware
{
    /**
     * Set type
     *
     * @param string|null $identifier Type identifier
     *
     * @return self
     */
    public function setType(string|null $identifier): static;

    /**
     * Get type
     *
     * If no type value set, method
     * sets and returns a default type.
     *
     * @see getDefaultType()
     *
     * @return string|null type or null if no type has been set
     */
    public function getType(): string|null;

    /**
     * Check if type has been set
     *
     * @return bool True if type has been set, false if not
     */
    public function hasType(): bool;

    /**
     * Get a default type value, if any is available
     *
     * @return string|null Default type value or null if no default value is available
     */
    public function getDefaultType(): string|null;
}
