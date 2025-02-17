<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Milestone Aware
 *
 * Component is aware of int "milestone"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface MilestoneAware
{
    /**
     * Set milestone
     *
     * @param int|null $identifier A marker that signifies a change, state, location or action
     *
     * @return self
     */
    public function setMilestone(int|null $identifier): static;

    /**
     * Get milestone
     *
     * If no milestone value set, method
     * sets and returns a default milestone.
     *
     * @see getDefaultMilestone()
     *
     * @return int|null milestone or null if no milestone has been set
     */
    public function getMilestone(): int|null;

    /**
     * Check if milestone has been set
     *
     * @return bool True if milestone has been set, false if not
     */
    public function hasMilestone(): bool;

    /**
     * Get a default milestone value, if any is available
     *
     * @return int|null Default milestone value or null if no default value is available
     */
    public function getDefaultMilestone(): int|null;
}
