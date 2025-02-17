<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Expires at Aware
 *
 * Component is aware of int "expires at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface ExpiresAtAware
{
    /**
     * Set expires at
     *
     * @param int|null $date Date of when this component, entity or resource is going to expire
     *
     * @return self
     */
    public function setExpiresAt(int|null $date): static;

    /**
     * Get expires at
     *
     * If no expires at value set, method
     * sets and returns a default expires at.
     *
     * @see getDefaultExpiresAt()
     *
     * @return int|null expires at or null if no expires at has been set
     */
    public function getExpiresAt(): int|null;

    /**
     * Check if expires at has been set
     *
     * @return bool True if expires at has been set, false if not
     */
    public function hasExpiresAt(): bool;

    /**
     * Get a default expires at value, if any is available
     *
     * @return int|null Default expires at value or null if no default value is available
     */
    public function getDefaultExpiresAt(): int|null;
}
