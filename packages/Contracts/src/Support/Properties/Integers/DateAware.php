<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * Date Aware
 *
 * Component is aware of int "date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface DateAware
{
    /**
     * Set date
     *
     * @param int|null $date Date of event
     *
     * @return self
     */
    public function setDate(?int $date);

    /**
     * Get date
     *
     * If no "date" value set, method
     * sets and returns a default "date".
     *
     * @see getDefaultDate()
     *
     * @return int|null date or null if no date has been set
     */
    public function getDate(): ?int;

    /**
     * Check if "date" has been set
     *
     * @return bool True if "date" has been set, false if not
     */
    public function hasDate(): bool;

    /**
     * Get a default "date" value, if any is available
     *
     * @return int|null Default "date" value or null if no default value is available
     */
    public function getDefaultDate(): ?int;
}
