<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Status Aware
 *
 * Component is aware of int "status"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface StatusAware
{
    /**
     * Set status
     *
     * @param int|null $status Situation of progress, classification, or civil status
     *
     * @return self
     */
    public function setStatus(int|null $status): static;

    /**
     * Get status
     *
     * If no status value set, method
     * sets and returns a default status.
     *
     * @see getDefaultStatus()
     *
     * @return int|null status or null if no status has been set
     */
    public function getStatus(): int|null;

    /**
     * Check if status has been set
     *
     * @return bool True if status has been set, false if not
     */
    public function hasStatus(): bool;

    /**
     * Get a default status value, if any is available
     *
     * @return int|null Default status value or null if no default value is available
     */
    public function getDefaultStatus(): int|null;
}
