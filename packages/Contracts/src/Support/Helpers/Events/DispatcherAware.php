<?php

namespace Aedart\Contracts\Support\Helpers\Events;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Dispatcher Aware
 *
 * @see \Illuminate\Contracts\Events\Dispatcher
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Events
 */
interface DispatcherAware
{
    /**
     * Set dispatcher
     *
     * @param Dispatcher|null $dispatcher Event dispatcher instance
     *
     * @return self
     */
    public function setDispatcher(?Dispatcher $dispatcher);

    /**
     * Get dispatcher
     *
     * If no dispatcher has been set, this method will
     * set and return a default dispatcher, if any such
     * value is available
     *
     * @return Dispatcher|null dispatcher or null if none dispatcher has been set
     */
    public function getDispatcher(): ?Dispatcher;

    /**
     * Check if dispatcher has been set
     *
     * @return bool True if dispatcher has been set, false if not
     */
    public function hasDispatcher(): bool;

    /**
     * Get a default dispatcher value, if any is available
     *
     * @return Dispatcher|null A default dispatcher value or Null if no default value is available
     */
    public function getDefaultDispatcher(): ?Dispatcher;
}
