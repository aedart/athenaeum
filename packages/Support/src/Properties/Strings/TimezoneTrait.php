<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Timezone Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\TimezoneAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait TimezoneTrait
{
    /**
     * Name of timezone
     *
     * @var string|null
     */
    protected string|null $timezone = null;

    /**
     * Set timezone
     *
     * @param string|null $name Name of timezone
     *
     * @return self
     */
    public function setTimezone(string|null $name): static
    {
        $this->timezone = $name;

        return $this;
    }

    /**
     * Get timezone
     *
     * If no timezone value set, method
     * sets and returns a default timezone.
     *
     * @see getDefaultTimezone()
     *
     * @return string|null timezone or null if no timezone has been set
     */
    public function getTimezone(): string|null
    {
        if (!$this->hasTimezone()) {
            $this->setTimezone($this->getDefaultTimezone());
        }
        return $this->timezone;
    }

    /**
     * Check if timezone has been set
     *
     * @return bool True if timezone has been set, false if not
     */
    public function hasTimezone(): bool
    {
        return isset($this->timezone);
    }

    /**
     * Get a default timezone value, if any is available
     *
     * @return string|null Default timezone value or null if no default value is available
     */
    public function getDefaultTimezone(): string|null
    {
        return null;
    }
}
