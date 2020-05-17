<?php

namespace Aedart\Circuits;

use Aedart\Circuits\Stores\CacheStore;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Manager as CircuitBreakerManager;
use Aedart\Contracts\Circuits\Store;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Support\Helpers\Config\ConfigTrait;

/**
 * Circuit Breaker Manager
 *
 * @see \Aedart\Contracts\Circuits\Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits
 */
class Manager implements
    CircuitBreakerManager,
    ConfigAware
{
    use ConfigTrait;

    /**
     * List of created circuit breakers
     *
     * @var CircuitBreaker[]
     */
    protected array $circuitBreakers = [];

    /**
     * @inheritDoc
     */
    public function create(string $service, array $options = [], bool $autoCreate = false): CircuitBreaker
    {
        // Return existing circuit breaker, if available
        if (isset($this->circuitBreakers[$service])) {
            return $this->circuitBreakers[$service];
        }

        // Create new instance, if possible
        return $this->circuitBreakers[$service] = $this->createCircuitBreaker(
            $service,
            $options,
            $autoCreate
        );
    }

    /**
     * @inheritDoc
     */
    public function store(string $service, string $driver = null, array $options = []): Store
    {
        $driver = $driver ?? $this->defaultStore();

        return new $driver($service, $options);
    }

    /**
     * @inheritDoc
     */
    public function defaultStore(): string
    {
        return $this->getConfig()->get('circuit-breakers.default_store', CacheStore::class);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    // TODO: ...
    protected function createCircuitBreaker(string $service, array $options = [], bool $autoCreate = false): CircuitBreaker
    {
        // TODO: Find service in config
            // TODO: If not found, fail when auto create = false

        // TODO: Merge options...

        // TODO: Find & create store...

        // TODO: etc...
    }
}
