<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Identifier Aware
 *
 * Component is aware of string "identifier"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface IdentifierAware
{
    /**
     * Set identifier
     *
     * @param string|null $identifier Name or code that identifies a unique object, resource, class, component or thing
     *
     * @return self
     */
    public function setIdentifier(string|null $identifier): static;

    /**
     * Get identifier
     *
     * If no identifier value set, method
     * sets and returns a default identifier.
     *
     * @see getDefaultIdentifier()
     *
     * @return string|null identifier or null if no identifier has been set
     */
    public function getIdentifier(): string|null;

    /**
     * Check if identifier has been set
     *
     * @return bool True if identifier has been set, false if not
     */
    public function hasIdentifier(): bool;

    /**
     * Get a default identifier value, if any is available
     *
     * @return string|null Default identifier value or null if no default value is available
     */
    public function getDefaultIdentifier(): string|null;
}
