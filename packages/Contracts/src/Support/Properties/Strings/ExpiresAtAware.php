<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Expires at Aware
 *
 * Component is aware of string "expires at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ExpiresAtAware
{
    /**
     * Set expires at
     *
     * @param string|null $date Date of when this component, entity or resource is going to expire
     *
     * @return self
     */
    public function setExpiresAt(string|null $date): static;

    /**
     * Get expires at
     *
     * If no expires at value set, method
     * sets and returns a default expires at.
     *
     * @see getDefaultExpiresAt()
     *
     * @return string|null expires at or null if no expires at has been set
     */
    public function getExpiresAt(): string|null;

    /**
     * Check if expires at has been set
     *
     * @return bool True if expires at has been set, false if not
     */
    public function hasExpiresAt(): bool;

    /**
     * Get a default expires at value, if any is available
     *
     * @return string|null Default expires at value or null if no default value is available
     */
    public function getDefaultExpiresAt(): string|null;
}
