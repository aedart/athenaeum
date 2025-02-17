<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Calendar Aware
 *
 * Component is aware of string "calendar"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface CalendarAware
{
    /**
     * Set calendar
     *
     * @param string|null $location Location to calendar, e.g. URI, name, ID or other identifier
     *
     * @return self
     */
    public function setCalendar(string|null $location): static;

    /**
     * Get calendar
     *
     * If no calendar value set, method
     * sets and returns a default calendar.
     *
     * @see getDefaultCalendar()
     *
     * @return string|null calendar or null if no calendar has been set
     */
    public function getCalendar(): string|null;

    /**
     * Check if calendar has been set
     *
     * @return bool True if calendar has been set, false if not
     */
    public function hasCalendar(): bool;

    /**
     * Get a default calendar value, if any is available
     *
     * @return string|null Default calendar value or null if no default value is available
     */
    public function getDefaultCalendar(): string|null;
}
