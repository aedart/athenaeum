<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Duration Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\DurationAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait DurationTrait
{
    /**
     * Duration of some event or media
     *
     * @var float|null
     */
    protected float|null $duration = null;

    /**
     * Set duration
     *
     * @param float|null $amount Duration of some event or media
     *
     * @return self
     */
    public function setDuration(float|null $amount): static
    {
        $this->duration = $amount;

        return $this;
    }

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
    public function getDuration(): float|null
    {
        if (!$this->hasDuration()) {
            $this->setDuration($this->getDefaultDuration());
        }
        return $this->duration;
    }

    /**
     * Check if duration has been set
     *
     * @return bool True if duration has been set, false if not
     */
    public function hasDuration(): bool
    {
        return isset($this->duration);
    }

    /**
     * Get a default duration value, if any is available
     *
     * @return float|null Default duration value or null if no default value is available
     */
    public function getDefaultDuration(): float|null
    {
        return null;
    }
}
