<?php

namespace Aedart\Support\Helpers\Events;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Event;

/**
 * Event Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Events\EventAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Events
 */
trait EventTrait
{
    /**
     * Event Dispatcher instance
     *
     * @var Dispatcher|null
     */
    protected ?Dispatcher $event = null;

    /**
     * Set event
     *
     * @param Dispatcher|null $dispatcher Event Dispatcher instance
     *
     * @return self
     */
    public function setEvent(?Dispatcher $dispatcher)
    {
        $this->event = $dispatcher;

        return $this;
    }

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
    public function getEvent(): ?Dispatcher
    {
        if (!$this->hasEvent()) {
            $this->setEvent($this->getDefaultEvent());
        }
        return $this->event;
    }

    /**
     * Check if event has been set
     *
     * @return bool True if event has been set, false if not
     */
    public function hasEvent(): bool
    {
        return isset($this->event);
    }

    /**
     * Get a default event value, if any is available
     *
     * @return Dispatcher|null A default event value or Null if no default value is available
     */
    public function getDefaultEvent(): ?Dispatcher
    {
        return Event::getFacadeRoot();
    }
}
