<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Duration Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DurationAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DurationTrait
{
    /**
     * Duration of some event or media
     *
     * @var string|null
     */
    protected string|null $duration = null;

    /**
     * Set duration
     *
     * @param string|null $amount Duration of some event or media
     *
     * @return self
     */
    public function setDuration(string|null $amount): static
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
     * @return string|null duration or null if no duration has been set
     */
    public function getDuration(): string|null
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
     * @return string|null Default duration value or null if no default value is available
     */
    public function getDefaultDuration(): string|null
    {
        return null;
    }
}
