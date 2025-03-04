<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Event Aware
 *
 * Component is aware of string "event"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface EventAware
{
    /**
     * Set event
     *
     * @param string|null $identifier Event name or identifier
     *
     * @return self
     */
    public function setEvent(string|null $identifier): static;

    /**
     * Get event
     *
     * If no event value set, method
     * sets and returns a default event.
     *
     * @see getDefaultEvent()
     *
     * @return string|null event or null if no event has been set
     */
    public function getEvent(): string|null;

    /**
     * Check if event has been set
     *
     * @return bool True if event has been set, false if not
     */
    public function hasEvent(): bool;

    /**
     * Get a default event value, if any is available
     *
     * @return string|null Default event value or null if no default value is available
     */
    public function getDefaultEvent(): string|null;
}
