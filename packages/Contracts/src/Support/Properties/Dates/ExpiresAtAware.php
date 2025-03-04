<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Expires at Aware
 *
 * Component is aware of \DateTimeInterface "expires at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface ExpiresAtAware
{
    /**
     * Set expires at
     *
     * @param \DateTimeInterface|null $date Date of when this component, entity or resource is going to expire
     *
     * @return self
     */
    public function setExpiresAt(\DateTimeInterface|null $date): static;

    /**
     * Get expires at
     *
     * If no expires at value set, method
     * sets and returns a default expires at.
     *
     * @see getDefaultExpiresAt()
     *
     * @return \DateTimeInterface|null expires at or null if no expires at has been set
     */
    public function getExpiresAt(): \DateTimeInterface|null;

    /**
     * Check if expires at has been set
     *
     * @return bool True if expires at has been set, false if not
     */
    public function hasExpiresAt(): bool;

    /**
     * Get a default expires at value, if any is available
     *
     * @return \DateTimeInterface|null Default expires at value or null if no default value is available
     */
    public function getDefaultExpiresAt(): \DateTimeInterface|null;
}
