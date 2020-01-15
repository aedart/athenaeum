<?php

namespace Aedart\Contracts\Support\Helpers\Cache;

use Illuminate\Contracts\Cache\Factory;

/**
 * Cache Factory Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Cache
 */
interface CacheFactoryAware
{
    /**
     * Set cache factory
     *
     * @param Factory|null $factory Cache Factory instance
     *
     * @return self
     */
    public function setCacheFactory(?Factory $factory);

    /**
     * Get cache factory
     *
     * If no cache factory has been set, this method will
     * set and return a default cache factory, if any such
     * value is available
     *
     * @see getDefaultCacheFactory()
     *
     * @return Factory|null cache factory or null if none cache factory has been set
     */
    public function getCacheFactory(): ?Factory;

    /**
     * Check if cache factory has been set
     *
     * @return bool True if cache factory has been set, false if not
     */
    public function hasCacheFactory(): bool;

    /**
     * Get a default cache factory value, if any is available
     *
     * @return Factory|null A default cache factory value or Null if no default value is available
     */
    public function getDefaultCacheFactory(): ?Factory;
}
