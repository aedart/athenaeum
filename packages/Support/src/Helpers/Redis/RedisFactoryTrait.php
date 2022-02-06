<?php

namespace Aedart\Support\Helpers\Redis;

use Illuminate\Contracts\Redis\Factory;
use Illuminate\Support\Facades\Redis;

/**
 * Redis Factory Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Redis\RedisFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Redis
 */
trait RedisFactoryTrait
{
    /**
     * Redis Factory instance
     *
     * @var Factory|null
     */
    protected Factory|null $redisFactory = null;

    /**
     * Set redis factory
     *
     * @param Factory|null $factory Redis Factory instance
     *
     * @return self
     */
    public function setRedisFactory(Factory|null $factory): static
    {
        $this->redisFactory = $factory;

        return $this;
    }

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
    public function getRedisFactory(): Factory|null
    {
        if (!$this->hasRedisFactory()) {
            $this->setRedisFactory($this->getDefaultRedisFactory());
        }
        return $this->redisFactory;
    }

    /**
     * Check if redis factory has been set
     *
     * @return bool True if redis factory has been set, false if not
     */
    public function hasRedisFactory(): bool
    {
        return isset($this->redisFactory);
    }

    /**
     * Get a default redis factory value, if any is available
     *
     * @return Factory|null A default redis factory value or Null if no default value is available
     */
    public function getDefaultRedisFactory(): Factory|null
    {
        return Redis::getFacadeRoot();
    }
}
