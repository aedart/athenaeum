<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Duration Aware
 *
 * Component is aware of string "duration"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface DurationAware
{
    /**
     * Set duration
     *
     * @param string|null $amount Duration of some event or media
     *
     * @return self
     */
    public function setDuration(?string $amount);

    /**
     * Get duration
     *
     * If no "duration" value set, method
     * sets and returns a default "duration".
     *
     * @see getDefaultDuration()
     *
     * @return string|null duration or null if no duration has been set
     */
    public function getDuration() : ?string;

    /**
     * Check if "duration" has been set
     *
     * @return bool True if "duration" has been set, false if not
     */
    public function hasDuration() : bool;

    /**
     * Get a default "duration" value, if any is available
     *
     * @return string|null Default "duration" value or null if no default value is available
     */
    public function getDefaultDuration() : ?string;
}
