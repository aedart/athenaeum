<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Start date Aware
 *
 * Component is aware of \DateTime "start date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface StartDateAware
{
    /**
     * Set start date
     *
     * @param \DateTime|null $date Start date of event
     *
     * @return self
     */
    public function setStartDate(\DateTime|null $date): static;

    /**
     * Get start date
     *
     * If no start date value set, method
     * sets and returns a default start date.
     *
     * @see getDefaultStartDate()
     *
     * @return \DateTime|null start date or null if no start date has been set
     */
    public function getStartDate(): \DateTime|null;

    /**
     * Check if start date has been set
     *
     * @return bool True if start date has been set, false if not
     */
    public function hasStartDate(): bool;

    /**
     * Get a default start date value, if any is available
     *
     * @return \DateTime|null Default start date value or null if no default value is available
     */
    public function getDefaultStartDate(): \DateTime|null;
}
