<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Event Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\EventAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait EventTrait
{
    /**
     * Event name or identifier
     *
     * @var int|null
     */
    protected int|null $event = null;

    /**
     * Set event
     *
     * @param int|null $identifier Event name or identifier
     *
     * @return self
     */
    public function setEvent(int|null $identifier): static
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
     * @return int|null event or null if no event has been set
     */
    public function getEvent(): int|null
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
     * @return int|null Default event value or null if no default value is available
     */
    public function getDefaultEvent(): int|null
    {
        return null;
    }
}
