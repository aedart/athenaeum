<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * End Aware
 *
 * Component is aware of string "end"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface EndAware
{
    /**
     * Set end
     *
     * @param string|null $location Location, index or other identifier of when something ends
     *
     * @return self
     */
    public function setEnd(string|null $location): static;

    /**
     * Get end
     *
     * If no end value set, method
     * sets and returns a default end.
     *
     * @see getDefaultEnd()
     *
     * @return string|null end or null if no end has been set
     */
    public function getEnd(): string|null;

    /**
     * Check if end has been set
     *
     * @return bool True if end has been set, false if not
     */
    public function hasEnd(): bool;

    /**
     * Get a default end value, if any is available
     *
     * @return string|null Default end value or null if no default value is available
     */
    public function getDefaultEnd(): string|null;
}
