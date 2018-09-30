<?php

namespace Aedart\Contracts\Support\Helpers\Redis;

use Illuminate\Contracts\Redis\Factory;

/**
 * Redis Factory Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Redis
 */
interface RedisFactoryAware
{
    /**
     * Set redis factory
     *
     * @param Factory|null $factory Redis Factory instance
     *
     * @return self
     */
    public function setRedisFactory(?Factory $factory);

    /**
     * Get redis factory
     *
     * If no redis factory has been set, this method will
     * set and return a default redis factory, if any such
     * value is available
     *
     * @see getDefaultRedisFactory()
     *
     * @return Factory|null redis factory or null if none redis factory has been set
     */
    public function getRedisFactory(): ?Factory;

    /**
     * Check if redis factory has been set
     *
     * @return bool True if redis factory has been set, false if not
     */
    public function hasRedisFactory(): bool;

    /**
     * Get a default redis factory value, if any is available
     *
     * @return Factory|null A default redis factory value or Null if no default value is available
     */
    public function getDefaultRedisFactory(): ?Factory;
}
