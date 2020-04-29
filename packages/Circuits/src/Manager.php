<?php

namespace Aedart\Circuits;

use Aedart\Circuits\Stores\CacheStore;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Manager as CircuitBreakerManager;
use Aedart\Contracts\Circuits\Store;

/**
 * Circuit Breaker Manager
 *
 * @see \Aedart\Contracts\Circuits\Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits
 */
class Manager implements CircuitBreakerManager
{
    /**
     * @inheritDoc
     */
    public function create(string $service, array $options = [], bool $autoCreate = false): CircuitBreaker
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     */
    public function store(string $service, $driver = null, array $options = []): Store
    {
        $driver = $driver ?? $this->defaultStore();

        return new $driver($service, $options);
    }

    /**
     * @inheritDoc
     */
    public function defaultStore(): string
    {
        return CacheStore::class;
    }
}
