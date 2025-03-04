<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Status Aware
 *
 * Component is aware of string "status"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface StatusAware
{
    /**
     * Set status
     *
     * @param string|null $status Situation of progress, classification, or civil status
     *
     * @return self
     */
    public function setStatus(string|null $status): static;

    /**
     * Get status
     *
     * If no status value set, method
     * sets and returns a default status.
     *
     * @see getDefaultStatus()
     *
     * @return string|null status or null if no status has been set
     */
    public function getStatus(): string|null;

    /**
     * Check if status has been set
     *
     * @return bool True if status has been set, false if not
     */
    public function hasStatus(): bool;

    /**
     * Get a default status value, if any is available
     *
     * @return string|null Default status value or null if no default value is available
     */
    public function getDefaultStatus(): string|null;
}
