<?php

namespace Aedart\Contracts\Support\Helpers\Cache;

use Illuminate\Contracts\Cache\Store;

/**
 * Cache Store Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Cache
 */
interface CacheStoreAware
{
    /**
     * Set cache store
     *
     * @param Store|null $store Cache Store instance
     *
     * @return self
     */
    public function setCacheStore(Store|null $store): static;

    /**
     * Get cache store
     *
     * If no cache store has been set, this method will
     * set and return a default cache store, if any such
     * value is available
     *
     * @see getDefaultCacheStore()
     *
     * @return Store|null cache store or null if none cache store has been set
     */
    public function getCacheStore(): Store|null;

    /**
     * Check if cache store has been set
     *
     * @return bool True if cache store has been set, false if not
     */
    public function hasCacheStore(): bool;

    /**
     * Get a default cache store value, if any is available
     *
     * @return Store|null A default cache store value or Null if no default value is available
     */
    public function getDefaultCacheStore(): Store|null;
}
