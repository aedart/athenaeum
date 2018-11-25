<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Duration Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\DurationAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait DurationTrait
{
    /**
     * Duration of some event or media
     *
     * @var int|null
     */
    protected $duration = null;

    /**
     * Set duration
     *
     * @param int|null $amount Duration of some event or media
     *
     * @return self
     */
    public function setDuration(?int $amount)
    {
        $this->duration = $amount;

        return $this;
    }

    /**
     * Get duration
     *
     * If no "duration" value set, method
     * sets and returns a default "duration".
     *
     * @see getDefaultDuration()
     *
     * @return int|null duration or null if no duration has been set
     */
    public function getDuration() : ?int
    {
        if ( ! $this->hasDuration()) {
            $this->setDuration($this->getDefaultDuration());
        }
        return $this->duration;
    }

    /**
     * Check if "duration" has been set
     *
     * @return bool True if "duration" has been set, false if not
     */
    public function hasDuration() : bool
    {
        return isset($this->duration);
    }

    /**
     * Get a default "duration" value, if any is available
     *
     * @return int|null Default "duration" value or null if no default value is available
     */
    public function getDefaultDuration() : ?int
    {
        return null;
    }
}
