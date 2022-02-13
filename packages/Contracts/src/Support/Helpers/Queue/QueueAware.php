<?php

namespace Aedart\Contracts\Support\Helpers\Queue;

use Illuminate\Contracts\Queue\Queue;

/**
 * Queue Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Queue
 */
interface QueueAware
{
    /**
     * Set queue
     *
     * @param Queue|null $queue Queue instance
     *
     * @return self
     */
    public function setQueue(Queue|null $queue): static;

    /**
     * Get queue
     *
     * If no queue has been set, this method will
     * set and return a default queue, if any such
     * value is available
     *
     * @see getDefaultQueue()
     *
     * @return Queue|null queue or null if none queue has been set
     */
    public function getQueue(): Queue|null;

    /**
     * Check if queue has been set
     *
     * @return bool True if queue has been set, false if not
     */
    public function hasQueue(): bool;

    /**
     * Get a default queue value, if any is available
     *
     * @return Queue|null A default queue value or Null if no default value is available
     */
    public function getDefaultQueue(): Queue|null;
}
