<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Group Aware
 *
 * Component is aware of string "group"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface GroupAware
{
    /**
     * Set group
     *
     * @param string|null $identity Group identifier
     *
     * @return self
     */
    public function setGroup(string|null $identity): static;

    /**
     * Get group
     *
     * If no group value set, method
     * sets and returns a default group.
     *
     * @see getDefaultGroup()
     *
     * @return string|null group or null if no group has been set
     */
    public function getGroup(): string|null;

    /**
     * Check if group has been set
     *
     * @return bool True if group has been set, false if not
     */
    public function hasGroup(): bool;

    /**
     * Get a default group value, if any is available
     *
     * @return string|null Default group value or null if no default value is available
     */
    public function getDefaultGroup(): string|null;
}
