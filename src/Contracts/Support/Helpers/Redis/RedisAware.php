<?php

namespace Aedart\Contracts\Support\Helpers\Redis;

use Illuminate\Contracts\Redis\Connection;

/**
 * Redis Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Redis
 */
interface RedisAware
{
    /**
     * Set redis
     *
     * @param Connection|null $connection Redis Connection instance
     *
     * @return self
     */
    public function setRedis(?Connection $connection);

    /**
     * Get redis
     *
     * If no redis has been set, this method will
     * set and return a default redis, if any such
     * value is available
     *
     * @see getDefaultRedis()
     *
     * @return Connection|null redis or null if none redis has been set
     */
    public function getRedis(): ?Connection;

    /**
     * Check if redis has been set
     *
     * @return bool True if redis has been set, false if not
     */
    public function hasRedis(): bool;

    /**
     * Get a default redis value, if any is available
     *
     * @return Connection|null A default redis value or Null if no default value is available
     */
    public function getDefaultRedis(): ?Connection;
}
