<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * Duration Aware
 *
 * Component is aware of int "duration"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface DurationAware
{
    /**
     * Set duration
     *
     * @param int|null $amount Duration of some event or media
     *
     * @return self
     */
    public function setDuration(?int $amount);

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
    public function getDuration(): ?int;

    /**
     * Check if "duration" has been set
     *
     * @return bool True if "duration" has been set, false if not
     */
    public function hasDuration(): bool;

    /**
     * Get a default "duration" value, if any is available
     *
     * @return int|null Default "duration" value or null if no default value is available
     */
    public function getDefaultDuration(): ?int;
}
