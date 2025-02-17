<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Deceased at Aware
 *
 * Component is aware of int "deceased at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface DeceasedAtAware
{
    /**
     * Set deceased at
     *
     * @param int|null $date Date of when person, animal of something has died
     *
     * @return self
     */
    public function setDeceasedAt(int|null $date): static;

    /**
     * Get deceased at
     *
     * If no deceased at value set, method
     * sets and returns a default deceased at.
     *
     * @see getDefaultDeceasedAt()
     *
     * @return int|null deceased at or null if no deceased at has been set
     */
    public function getDeceasedAt(): int|null;

    /**
     * Check if deceased at has been set
     *
     * @return bool True if deceased at has been set, false if not
     */
    public function hasDeceasedAt(): bool;

    /**
     * Get a default deceased at value, if any is available
     *
     * @return int|null Default deceased at value or null if no default value is available
     */
    public function getDefaultDeceasedAt(): int|null;
}
