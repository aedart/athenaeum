<?php

namespace Aedart\Contracts\Support\Helpers\Events;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Event Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Events
 */
interface EventAware
{
    /**
     * Set event
     *
     * @param Dispatcher|null $dispatcher Event Dispatcher instance
     *
     * @return self
     */
    public function setEvent(?Dispatcher $dispatcher);

    /**
     * Get event
     *
     * If no event has been set, this method will
     * set and return a default event, if any such
     * value is available
     *
     * @see getDefaultEvent()
     *
     * @return Dispatcher|null event or null if none event has been set
     */
    public function getEvent(): ?Dispatcher;

    /**
     * Check if event has been set
     *
     * @return bool True if event has been set, false if not
     */
    public function hasEvent(): bool;

    /**
     * Get a default event value, if any is available
     *
     * @return Dispatcher|null A default event value or Null if no default value is available
     */
    public function getDefaultEvent(): ?Dispatcher;
}
