<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Milestone Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\MilestoneAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait MilestoneTrait
{
    /**
     * A marker that signifies a change, state, location or action
     *
     * @var int|null
     */
    protected int|null $milestone = null;

    /**
     * Set milestone
     *
     * @param int|null $identifier A marker that signifies a change, state, location or action
     *
     * @return self
     */
    public function setMilestone(int|null $identifier): static
    {
        $this->milestone = $identifier;

        return $this;
    }

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
    public function getMilestone(): int|null
    {
        if (!$this->hasMilestone()) {
            $this->setMilestone($this->getDefaultMilestone());
        }
        return $this->milestone;
    }

    /**
     * Check if milestone has been set
     *
     * @return bool True if milestone has been set, false if not
     */
    public function hasMilestone(): bool
    {
        return isset($this->milestone);
    }

    /**
     * Get a default milestone value, if any is available
     *
     * @return int|null Default milestone value or null if no default value is available
     */
    public function getDefaultMilestone(): int|null
    {
        return null;
    }
}
