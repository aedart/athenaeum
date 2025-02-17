<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Updated at Aware
 *
 * Component is aware of string "updated at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface UpdatedAtAware
{
    /**
     * Set updated at
     *
     * @param string|null $date Date of when this component, entity or resource was updated
     *
     * @return self
     */
    public function setUpdatedAt(string|null $date): static;

    /**
     * Get updated at
     *
     * If no updated at value set, method
     * sets and returns a default updated at.
     *
     * @see getDefaultUpdatedAt()
     *
     * @return string|null updated at or null if no updated at has been set
     */
    public function getUpdatedAt(): string|null;

    /**
     * Check if updated at has been set
     *
     * @return bool True if updated at has been set, false if not
     */
    public function hasUpdatedAt(): bool;

    /**
     * Get a default updated at value, if any is available
     *
     * @return string|null Default updated at value or null if no default value is available
     */
    public function getDefaultUpdatedAt(): string|null;
}
