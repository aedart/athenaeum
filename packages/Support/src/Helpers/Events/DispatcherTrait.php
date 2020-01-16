<?php

namespace Aedart\Support\Helpers\Events;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Event;

/**
 * Dispatcher Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Events\DispatcherAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Events
 */
trait DispatcherTrait
{
    /**
     * Event dispatcher instance
     *
     * @var Dispatcher|null
     */
    protected ?Dispatcher $dispatcher = null;

    /**
     * Set dispatcher
     *
     * @param Dispatcher|null $dispatcher Event dispatcher instance
     *
     * @return self
     */
    public function setDispatcher(?Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * Get dispatcher
     *
     * If no dispatcher has been set, this method will
     * set and return a default dispatcher, if any such
     * value is available
     *
     * @return Dispatcher|null dispatcher or null if none dispatcher has been set
     */
    public function getDispatcher(): ?Dispatcher
    {
        if (!$this->hasDispatcher()) {
            $this->setDispatcher($this->getDefaultDispatcher());
        }
        return $this->dispatcher;
    }

    /**
     * Check if dispatcher has been set
     *
     * @return bool True if dispatcher has been set, false if not
     */
    public function hasDispatcher(): bool
    {
        return isset($this->dispatcher);
    }

    /**
     * Get a default dispatcher value, if any is available
     *
     * @return Dispatcher|null A default dispatcher value or Null if no default value is available
     */
    public function getDefaultDispatcher(): ?Dispatcher
    {
        return Event::getFacadeRoot();
    }
}
