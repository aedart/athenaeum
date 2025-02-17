<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Group Aware
 *
 * Component is aware of int "group"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface GroupAware
{
    /**
     * Set group
     *
     * @param int|null $identity Group identifier
     *
     * @return self
     */
    public function setGroup(int|null $identity): static;

    /**
     * Get group
     *
     * If no group value set, method
     * sets and returns a default group.
     *
     * @see getDefaultGroup()
     *
     * @return int|null group or null if no group has been set
     */
    public function getGroup(): int|null;

    /**
     * Check if group has been set
     *
     * @return bool True if group has been set, false if not
     */
    public function hasGroup(): bool;

    /**
     * Get a default group value, if any is available
     *
     * @return int|null Default group value or null if no default value is available
     */
    public function getDefaultGroup(): int|null;
}
