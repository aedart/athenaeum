<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Event Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\EventAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait EventTrait
{
    /**
     * Event name or identifier
     *
     * @var string|null
     */
    protected string|null $event = null;

    /**
     * Set event
     *
     * @param string|null $identifier Event name or identifier
     *
     * @return self
     */
    public function setEvent(string|null $identifier): static
    {
        $this->event = $identifier;

        return $this;
    }

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
    public function getEvent(): string|null
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
     * @return string|null Default event value or null if no default value is available
     */
    public function getDefaultEvent(): string|null
    {
        return null;
    }
}
