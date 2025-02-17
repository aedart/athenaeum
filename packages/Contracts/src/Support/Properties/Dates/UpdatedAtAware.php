<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Updated at Aware
 *
 * Component is aware of \DateTimeInterface "updated at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface UpdatedAtAware
{
    /**
     * Set updated at
     *
     * @param \DateTimeInterface|null $date Date of when this component, entity or resource was updated
     *
     * @return self
     */
    public function setUpdatedAt(\DateTimeInterface|null $date): static;

    /**
     * Get updated at
     *
     * If no updated at value set, method
     * sets and returns a default updated at.
     *
     * @see getDefaultUpdatedAt()
     *
     * @return \DateTimeInterface|null updated at or null if no updated at has been set
     */
    public function getUpdatedAt(): \DateTimeInterface|null;

    /**
     * Check if updated at has been set
     *
     * @return bool True if updated at has been set, false if not
     */
    public function hasUpdatedAt(): bool;

    /**
     * Get a default updated at value, if any is available
     *
     * @return \DateTimeInterface|null Default updated at value or null if no default value is available
     */
    public function getDefaultUpdatedAt(): \DateTimeInterface|null;
}
