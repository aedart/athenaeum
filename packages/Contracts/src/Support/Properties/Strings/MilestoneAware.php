<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Milestone Aware
 *
 * Component is aware of string "milestone"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface MilestoneAware
{
    /**
     * Set milestone
     *
     * @param string|null $identifier A marker that signifies a change, state, location or action
     *
     * @return self
     */
    public function setMilestone(string|null $identifier): static;

    /**
     * Get milestone
     *
     * If no milestone value set, method
     * sets and returns a default milestone.
     *
     * @see getDefaultMilestone()
     *
     * @return string|null milestone or null if no milestone has been set
     */
    public function getMilestone(): string|null;

    /**
     * Check if milestone has been set
     *
     * @return bool True if milestone has been set, false if not
     */
    public function hasMilestone(): bool;

    /**
     * Get a default milestone value, if any is available
     *
     * @return string|null Default milestone value or null if no default value is available
     */
    public function getDefaultMilestone(): string|null;
}
