<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * End date Aware
 *
 * Component is aware of int "end date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface EndDateAware
{
    /**
     * Set end date
     *
     * @param int|null $date Date for when some kind of event ends
     *
     * @return self
     */
    public function setEndDate(int|null $date): static;

    /**
     * Get end date
     *
     * If no end date value set, method
     * sets and returns a default end date.
     *
     * @see getDefaultEndDate()
     *
     * @return int|null end date or null if no end date has been set
     */
    public function getEndDate(): int|null;

    /**
     * Check if end date has been set
     *
     * @return bool True if end date has been set, false if not
     */
    public function hasEndDate(): bool;

    /**
     * Get a default end date value, if any is available
     *
     * @return int|null Default end date value or null if no default value is available
     */
    public function getDefaultEndDate(): int|null;
}
