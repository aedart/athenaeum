<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Deleted at Aware
 *
 * Component is aware of \DateTimeInterface "deleted at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface DeletedAtAware
{
    /**
     * Set deleted at
     *
     * @param \DateTimeInterface|null $date Date of when this component, entity or resource was deleted
     *
     * @return self
     */
    public function setDeletedAt(\DateTimeInterface|null $date): static;

    /**
     * Get deleted at
     *
     * If no deleted at value set, method
     * sets and returns a default deleted at.
     *
     * @see getDefaultDeletedAt()
     *
     * @return \DateTimeInterface|null deleted at or null if no deleted at has been set
     */
    public function getDeletedAt(): \DateTimeInterface|null;

    /**
     * Check if deleted at has been set
     *
     * @return bool True if deleted at has been set, false if not
     */
    public function hasDeletedAt(): bool;

    /**
     * Get a default deleted at value, if any is available
     *
     * @return \DateTimeInterface|null Default deleted at value or null if no default value is available
     */
    public function getDefaultDeletedAt(): \DateTimeInterface|null;
}
