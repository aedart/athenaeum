<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Timezone Aware
 *
 * Component is aware of string "timezone"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface TimezoneAware
{
    /**
     * Set timezone
     *
     * @param string|null $name Name of timezone
     *
     * @return self
     */
    public function setTimezone(string|null $name): static;

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
    public function getTimezone(): string|null;

    /**
     * Check if timezone has been set
     *
     * @return bool True if timezone has been set, false if not
     */
    public function hasTimezone(): bool;

    /**
     * Get a default timezone value, if any is available
     *
     * @return string|null Default timezone value or null if no default value is available
     */
    public function getDefaultTimezone(): string|null;
}
