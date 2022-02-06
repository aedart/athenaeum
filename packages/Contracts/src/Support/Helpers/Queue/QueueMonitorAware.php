<?php

namespace Aedart\Contracts\Support\Helpers\Queue;

use Illuminate\Contracts\Queue\Monitor;

/**
 * Queue Monitor Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Queue
 */
interface QueueMonitorAware
{
    /**
     * Set queue monitor
     *
     * @param Monitor|null $monitor Queue Monitor instance
     *
     * @return self
     */
    public function setQueueMonitor(Monitor|null $monitor): static;

    /**
     * Get queue monitor
     *
     * If no queue monitor has been set, this method will
     * set and return a default queue monitor, if any such
     * value is available
     *
     * @see getDefaultQueueMonitor()
     *
     * @return Monitor|null queue monitor or null if none queue monitor has been set
     */
    public function getQueueMonitor(): Monitor|null;

    /**
     * Check if queue monitor has been set
     *
     * @return bool True if queue monitor has been set, false if not
     */
    public function hasQueueMonitor(): bool;

    /**
     * Get a default queue monitor value, if any is available
     *
     * @return Monitor|null A default queue monitor value or Null if no default value is available
     */
    public function getDefaultQueueMonitor(): Monitor|null;
}
