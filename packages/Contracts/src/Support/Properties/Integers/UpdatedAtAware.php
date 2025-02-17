<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Updated at Aware
 *
 * Component is aware of int "updated at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface UpdatedAtAware
{
    /**
     * Set updated at
     *
     * @param int|null $date Date of when this component, entity or resource was updated
     *
     * @return self
     */
    public function setUpdatedAt(int|null $date): static;

    /**
     * Get updated at
     *
     * If no updated at value set, method
     * sets and returns a default updated at.
     *
     * @see getDefaultUpdatedAt()
     *
     * @return int|null updated at or null if no updated at has been set
     */
    public function getUpdatedAt(): int|null;

    /**
     * Check if updated at has been set
     *
     * @return bool True if updated at has been set, false if not
     */
    public function hasUpdatedAt(): bool;

    /**
     * Get a default updated at value, if any is available
     *
     * @return int|null Default updated at value or null if no default value is available
     */
    public function getDefaultUpdatedAt(): int|null;
}
