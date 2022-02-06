<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Deceased at Aware
 *
 * Component is aware of \DateTime "deceased at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface DeceasedAtAware
{
    /**
     * Set deceased at
     *
     * @param \DateTime|null $date Date of when person, animal of something has died
     *
     * @return self
     */
    public function setDeceasedAt(\DateTime|null $date): static;

    /**
     * Get deceased at
     *
     * If no deceased at value set, method
     * sets and returns a default deceased at.
     *
     * @see getDefaultDeceasedAt()
     *
     * @return \DateTime|null deceased at or null if no deceased at has been set
     */
    public function getDeceasedAt(): \DateTime|null;

    /**
     * Check if deceased at has been set
     *
     * @return bool True if deceased at has been set, false if not
     */
    public function hasDeceasedAt(): bool;

    /**
     * Get a default deceased at value, if any is available
     *
     * @return \DateTime|null Default deceased at value or null if no default value is available
     */
    public function getDefaultDeceasedAt(): \DateTime|null;
}
