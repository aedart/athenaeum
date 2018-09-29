<?php

namespace Aedart\Support\Helpers\Cache;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;

/**
 * Cache Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Cache\CacheAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Cache
 */
trait CacheTrait
{
    /**
     * Cache Repository instance
     *
     * @var Repository|null
     */
    protected $cache = null;

    /**
     * Set cache
     *
     * @param Repository|null $repository Cache Repository instance
     *
     * @return self
     */
    public function setCache(?Repository $repository)
    {
        $this->cache = $repository;

        return $this;
    }

    /**
     * Get cache
     *
     * If no cache has been set, this method will
     * set and return a default cache, if any such
     * value is available
     *
     * @see getDefaultCache()
     *
     * @return Repository|null cache or null if none cache has been set
     */
    public function getCache(): ?Repository
    {
        if (!$this->hasCache()) {
            $this->setCache($this->getDefaultCache());
        }
        return $this->cache;
    }

    /**
     * Check if cache has been set
     *
     * @return bool True if cache has been set, false if not
     */
    public function hasCache(): bool
    {
        return isset($this->cache);
    }

    /**
     * Get a default cache value, if any is available
     *
     * @return Repository|null A default cache value or Null if no default value is available
     */
    public function getDefaultCache(): ?Repository
    {
        $manager = Cache::getFacadeRoot();
        if (isset($manager)) {
            return $cache = $manager->store();
        }
        return $manager;
    }
}
