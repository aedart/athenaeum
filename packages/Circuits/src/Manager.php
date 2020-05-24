<?php

namespace Aedart\Circuits;

use Aedart\Circuits\Exceptions\ProfileNotFound;
use Aedart\Circuits\Stores\CacheStore;
use Aedart\Contracts\Circuits\CircuitBreaker as CircuitBreakerInterface;
use Aedart\Contracts\Circuits\Exceptions\ProfileNotFoundException;
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
    public function create(string $service, array $options = []): CircuitBreakerInterface
    {
        // Return existing circuit breaker, if available
        if (isset($this->circuitBreakers[$service])) {
            return $this->circuitBreakers[$service];
        }

        // Create new instance, if possible
        return $this->circuitBreakers[$service] = $this->createCircuitBreaker($service, $options);
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

    /**
     * Create circuit breaker instance
     *
     * @param string $service
     * @param array $options [optional]
     *
     * @return CircuitBreakerInterface
     *
     * @throws ProfileNotFoundException
     */
    protected function createCircuitBreaker(string $service, array $options = []): CircuitBreakerInterface
    {
        // Obtain "service" configuration
        $options = array_merge(
            $this->findOrFailServiceConfiguration($service),
            $options
        );

        // Create store
        $store = $this->createStore($service, $options['store'] ?? null);

        // Finally, create circuit breaker
        return (new CircuitBreaker($service, $options))
            ->setStore($store);
    }

    /**
     * Creates new store instance, using predefined configuration.
     * Fails if unable to find configuration for store.
     *
     * @param string $service
     * @param string $driver
     * @return Store
     *
     * @throws ProfileNotFoundException
     */
    protected function createStore(string $service, string $driver): Store
    {
        $configuration = $this->findOrFailStoreConfiguration($driver);
        $driver = $configuration['driver'] ?? null;
        $options = $configuration['options'] ?? [];

        return $this->store($service, $driver, $options);
    }

    /**
     * Find circuit breaker store configuration for given store (driver)
     * or fail
     *
     * @param string $store
     * @return array
     *
     * @throws ProfileNotFoundException
     */
    protected function findOrFailStoreConfiguration(string $store): array
    {
        $config = $this->getConfig();
        $key = 'circuit-breakers.stores.' . $store;

        if (!$config->has($key)) {
            $notFoundMsg = $notFoundMsg ?? 'Store (profile) "%s" does not exist';
            throw new ProfileNotFound(sprintf($notFoundMsg, $store));
        }

        return $config->get($key);
    }

    /**
     * Find circuit breaker configuration for given service (profile)
     * or fail
     *
     * @param string $service
     * @return array
     *
     * @throws ProfileNotFoundException
     */
    protected function findOrFailServiceConfiguration(string $service): array
    {
        $config = $this->getConfig();
        $key = 'circuit-breakers.services.' . $service;

        if (!$config->has($key)) {
            $notFoundMsg = $notFoundMsg ?? 'Service (profile) "%s" does not exist';
            throw new ProfileNotFound(sprintf($notFoundMsg, $service));
        }

        return $config->get($key);
    }
}
