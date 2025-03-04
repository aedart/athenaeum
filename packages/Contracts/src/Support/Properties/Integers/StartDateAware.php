<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Start date Aware
 *
 * Component is aware of int "start date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface StartDateAware
{
    /**
     * Set start date
     *
     * @param int|null $date Start date of event
     *
     * @return self
     */
    public function setStartDate(int|null $date): static;

    /**
     * Get start date
     *
     * If no start date value set, method
     * sets and returns a default start date.
     *
     * @see getDefaultStartDate()
     *
     * @return int|null start date or null if no start date has been set
     */
    public function getStartDate(): int|null;

    /**
     * Check if start date has been set
     *
     * @return bool True if start date has been set, false if not
     */
    public function hasStartDate(): bool;

    /**
     * Get a default start date value, if any is available
     *
     * @return int|null Default start date value or null if no default value is available
     */
    public function getDefaultStartDate(): int|null;
}
