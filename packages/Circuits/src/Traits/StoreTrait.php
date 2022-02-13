<?php

namespace Aedart\Circuits\Traits;

use Aedart\Contracts\Circuits\Store;

/**
 * Store Trait
 *
 * @see \Aedart\Contracts\Circuits\Stores\StoreAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Traits
 */
trait StoreTrait
{
    /**
     * Circuit Breaker Store instance
     *
     * @var Store|null
     */
    protected Store|null $store = null;

    /**
     * Set store
     *
     * @param Store|null $store Circuit Breaker Store instance
     *
     * @return self
     */
    public function setStore(Store|null $store): static
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * If no store has been set, this method will
     * set and return a default store, if any such
     * value is available
     *
     * @return Store|null store or null if none store has been set
     */
    public function getStore(): Store|null
    {
        if (!$this->hasStore()) {
            $this->setStore($this->getDefaultStore());
        }
        return $this->store;
    }

    /**
     * Check if store has been set
     *
     * @return bool True if store has been set, false if not
     */
    public function hasStore(): bool
    {
        return isset($this->store);
    }

    /**
     * Get a default store value, if any is available
     *
     * @return Store|null A default store value or Null if no default value is available
     */
    public function getDefaultStore(): Store|null
    {
        return null;
    }
}
