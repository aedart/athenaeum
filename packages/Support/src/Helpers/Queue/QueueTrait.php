<?php

namespace Aedart\Support\Helpers\Queue;

use Illuminate\Contracts\Queue\Queue;
use Illuminate\Support\Facades\Queue as QueueFacade;

/**
 * Queue Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Queue\QueueAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Queue
 */
trait QueueTrait
{
    /**
     * Queue instance
     *
     * @var Queue|null
     */
    protected Queue|null $queue = null;

    /**
     * Set queue
     *
     * @param Queue|null $queue Queue instance
     *
     * @return self
     */
    public function setQueue(Queue|null $queue): static
    {
        $this->queue = $queue;

        return $this;
    }

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
    public function getQueue(): Queue|null
    {
        if (!$this->hasQueue()) {
            $this->setQueue($this->getDefaultQueue());
        }
        return $this->queue;
    }

    /**
     * Check if queue has been set
     *
     * @return bool True if queue has been set, false if not
     */
    public function hasQueue(): bool
    {
        return isset($this->queue);
    }

    /**
     * Get a default queue value, if any is available
     *
     * @return Queue|null A default queue value or Null if no default value is available
     */
    public function getDefaultQueue(): Queue|null
    {
        $manager = QueueFacade::getFacadeRoot();
        if (isset($manager)) {
            return $manager->connection();
        }
        return $manager;
    }
}
