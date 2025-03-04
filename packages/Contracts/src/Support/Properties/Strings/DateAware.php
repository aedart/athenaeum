<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Date Aware
 *
 * Component is aware of string "date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface DateAware
{
    /**
     * Set date
     *
     * @param string|null $date Date of event
     *
     * @return self
     */
    public function setDate(string|null $date): static;

    /**
     * Get date
     *
     * If no date value set, method
     * sets and returns a default date.
     *
     * @see getDefaultDate()
     *
     * @return string|null date or null if no date has been set
     */
    public function getDate(): string|null;

    /**
     * Check if date has been set
     *
     * @return bool True if date has been set, false if not
     */
    public function hasDate(): bool;

    /**
     * Get a default date value, if any is available
     *
     * @return string|null Default date value or null if no default value is available
     */
    public function getDefaultDate(): string|null;
}
