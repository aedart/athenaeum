<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Duration Aware
 *
 * Component is aware of float "duration"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface DurationAware
{
    /**
     * Set duration
     *
     * @param float|null $amount Duration of some event or media
     *
     * @return self
     */
    public function setDuration(float|null $amount): static;

    /**
     * Get duration
     *
     * If no duration value set, method
     * sets and returns a default duration.
     *
     * @see getDefaultDuration()
     *
     * @return float|null duration or null if no duration has been set
     */
    public function getDuration(): float|null;

    /**
     * Check if duration has been set
     *
     * @return bool True if duration has been set, false if not
     */
    public function hasDuration(): bool;

    /**
     * Get a default duration value, if any is available
     *
     * @return float|null Default duration value or null if no default value is available
     */
    public function getDefaultDuration(): float|null;
}
