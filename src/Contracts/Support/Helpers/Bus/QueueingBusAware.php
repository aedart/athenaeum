<?php

namespace Aedart\Contracts\Support\Helpers\Bus;

use Illuminate\Contracts\Bus\QueueingDispatcher;

/**
 * Queueing Bus Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Bus
 */
interface QueueingBusAware
{
    /**
     * Set queueing bus
     *
     * @param QueueingDispatcher|null $dispatcher Bus Queueing Dispatcher instance
     *
     * @return self
     */
    public function setQueueingBus(?QueueingDispatcher $dispatcher);

    /**
     * Get queueing bus
     *
     * If no queueing bus has been set, this method will
     * set and return a default queueing bus, if any such
     * value is available
     *
     * @see getDefaultQueueingBus()
     *
     * @return QueueingDispatcher|null queueing bus or null if none queueing bus has been set
     */
    public function getQueueingBus(): ?QueueingDispatcher;

    /**
     * Check if queueing bus has been set
     *
     * @return bool True if queueing bus has been set, false if not
     */
    public function hasQueueingBus(): bool;

    /**
     * Get a default queueing bus value, if any is available
     *
     * @return QueueingDispatcher|null A default queueing bus value or Null if no default value is available
     */
    public function getDefaultQueueingBus(): ?QueueingDispatcher;
}
