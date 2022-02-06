<?php

namespace Aedart\Contracts\Support\Helpers\Bus;

use Illuminate\Contracts\Bus\Dispatcher;

/**
 * Bus Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Bus
 */
interface BusAware
{
    /**
     * Set bus
     *
     * @param Dispatcher|null $dispatcher Bus Dispatcher instance
     *
     * @return self
     */
    public function setBus(Dispatcher|null $dispatcher): static;

    /**
     * Get bus
     *
     * If no bus has been set, this method will
     * set and return a default bus, if any such
     * value is available
     *
     * @see getDefaultBus()
     *
     * @return Dispatcher|null bus or null if none bus has been set
     */
    public function getBus(): Dispatcher|null;

    /**
     * Check if bus has been set
     *
     * @return bool True if bus has been set, false if not
     */
    public function hasBus(): bool;

    /**
     * Get a default bus value, if any is available
     *
     * @return Dispatcher|null A default bus value or Null if no default value is available
     */
    public function getDefaultBus(): Dispatcher|null;
}
