<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Date Aware
 *
 * Component is aware of \DateTimeInterface "date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface DateAware
{
    /**
     * Set date
     *
     * @param \DateTimeInterface|null $date Date of event
     *
     * @return self
     */
    public function setDate(\DateTimeInterface|null $date): static;

    /**
     * Get date
     *
     * If no date value set, method
     * sets and returns a default date.
     *
     * @see getDefaultDate()
     *
     * @return \DateTimeInterface|null date or null if no date has been set
     */
    public function getDate(): \DateTimeInterface|null;

    /**
     * Check if date has been set
     *
     * @return bool True if date has been set, false if not
     */
    public function hasDate(): bool;

    /**
     * Get a default date value, if any is available
     *
     * @return \DateTimeInterface|null Default date value or null if no default value is available
     */
    public function getDefaultDate(): \DateTimeInterface|null;
}
