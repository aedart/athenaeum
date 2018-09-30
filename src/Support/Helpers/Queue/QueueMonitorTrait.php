<?php

namespace Aedart\Support\Helpers\Queue;

use Illuminate\Contracts\Queue\Monitor;
use Illuminate\Support\Facades\Queue;

/**
 * Queue Monitor Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Queue\QueueMonitorAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Queue
 */
trait QueueMonitorTrait
{
    /**
     * Queue Monitor instance
     *
     * @var Monitor|null
     */
    protected $queueMonitor = null;

    /**
     * Set queue monitor
     *
     * @param Monitor|null $monitor Queue Monitor instance
     *
     * @return self
     */
    public function setQueueMonitor(?Monitor $monitor)
    {
        $this->queueMonitor = $monitor;

        return $this;
    }

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
    public function getQueueMonitor(): ?Monitor
    {
        if (!$this->hasQueueMonitor()) {
            $this->setQueueMonitor($this->getDefaultQueueMonitor());
        }
        return $this->queueMonitor;
    }

    /**
     * Check if queue monitor has been set
     *
     * @return bool True if queue monitor has been set, false if not
     */
    public function hasQueueMonitor(): bool
    {
        return isset($this->queueMonitor);
    }

    /**
     * Get a default queue monitor value, if any is available
     *
     * @return Monitor|null A default queue monitor value or Null if no default value is available
     */
    public function getDefaultQueueMonitor(): ?Monitor
    {
        return Queue::getFacadeRoot();
    }
}
