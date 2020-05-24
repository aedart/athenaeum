<?php

namespace Aedart\Contracts\Circuits\Stores;

use Aedart\Contracts\Circuits\Store;

/**
 * Store Aware
 *
 * @see \Aedart\Contracts\Circuits\Store
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Stores
 */
interface StoreAware
{
    /**
     * Set store
     *
     * @param Store|null $store Circuit Breaker Store instance
     *
     * @return self
     */
    public function setStore(?Store $store);

    /**
     * Get store
     *
     * If no store has been set, this method will
     * set and return a default store, if any such
     * value is available
     *
     * @return Store|null store or null if none store has been set
     */
    public function getStore(): ?Store;

    /**
     * Check if store has been set
     *
     * @return bool True if store has been set, false if not
     */
    public function hasStore(): bool;

    /**
     * Get a default store value, if any is available
     *
     * @return Store|null A default store value or Null if no default value is available
     */
    public function getDefaultStore(): ?Store;
}
