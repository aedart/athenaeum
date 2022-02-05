<?php

namespace Aedart\Support\Helpers\Redis;

use Illuminate\Contracts\Redis\Connection;
use Illuminate\Support\Facades\Redis;

/**
 * Redis Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Redis\RedisAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Redis
 */
trait RedisTrait
{
    /**
     * Redis Connection instance
     *
     * @var Connection|null
     */
    protected Connection|null $redis = null;

    /**
     * Set redis
     *
     * @param Connection|null $connection Redis Connection instance
     *
     * @return self
     */
    public function setRedis(Connection|null $connection): static
    {
        $this->redis = $connection;

        return $this;
    }

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
    public function getRedis(): Connection|null
    {
        if (!$this->hasRedis()) {
            $this->setRedis($this->getDefaultRedis());
        }
        return $this->redis;
    }

    /**
     * Check if redis has been set
     *
     * @return bool True if redis has been set, false if not
     */
    public function hasRedis(): bool
    {
        return isset($this->redis);
    }

    /**
     * Get a default redis value, if any is available
     *
     * @return Connection|null A default redis value or Null if no default value is available
     */
    public function getDefaultRedis(): Connection|null
    {
        $factory = Redis::getFacadeRoot();
        if (isset($factory)) {
            return $factory->connection();
        }
        return $factory;
    }
}
