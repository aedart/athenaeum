<?php

namespace Aedart\Contracts\Support\Helpers\Queue;

use Illuminate\Contracts\Queue\Factory;

/**
 * Queue Factory Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Queue
 */
interface QueueFactoryAware
{
    /**
     * Set queue factory
     *
     * @param Factory|null $factory Queue Factory instance
     *
     * @return self
     */
    public function setQueueFactory(Factory|null $factory): static;

    /**
     * Get queue factory
     *
     * If no queue factory has been set, this method will
     * set and return a default queue factory, if any such
     * value is available
     *
     * @see getDefaultQueueFactory()
     *
     * @return Factory|null queue factory or null if none queue factory has been set
     */
    public function getQueueFactory(): Factory|null;

    /**
     * Check if queue factory has been set
     *
     * @return bool True if queue factory has been set, false if not
     */
    public function hasQueueFactory(): bool;

    /**
     * Get a default queue factory value, if any is available
     *
     * @return Factory|null A default queue factory value or Null if no default value is available
     */
    public function getDefaultQueueFactory(): Factory|null;
}
