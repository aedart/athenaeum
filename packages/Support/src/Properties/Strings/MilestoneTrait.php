<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Milestone Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\MilestoneAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait MilestoneTrait
{
    /**
     * A marker that signifies a change, state, location or action
     *
     * @var string|null
     */
    protected ?string $milestone = null;

    /**
     * Set milestone
     *
     * @param string|null $identifier A marker that signifies a change, state, location or action
     *
     * @return self
     */
    public function setMilestone(?string $identifier)
    {
        $this->milestone = $identifier;

        return $this;
    }

    /**
     * Get milestone
     *
     * If no "milestone" value set, method
     * sets and returns a default "milestone".
     *
     * @see getDefaultMilestone()
     *
     * @return string|null milestone or null if no milestone has been set
     */
    public function getMilestone() : ?string
    {
        if ( ! $this->hasMilestone()) {
            $this->setMilestone($this->getDefaultMilestone());
        }
        return $this->milestone;
    }

    /**
     * Check if "milestone" has been set
     *
     * @return bool True if "milestone" has been set, false if not
     */
    public function hasMilestone() : bool
    {
        return isset($this->milestone);
    }

    /**
     * Get a default "milestone" value, if any is available
     *
     * @return string|null Default "milestone" value or null if no default value is available
     */
    public function getDefaultMilestone() : ?string
    {
        return null;
    }
}
