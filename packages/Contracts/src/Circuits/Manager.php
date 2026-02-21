<?php

namespace Aedart\Contracts\Circuits;

use Aedart\Contracts\Circuits\Exceptions\ProfileNotFoundException;

/**
 * Circuit Breaker Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits
 */
interface Manager
{
    /**
     * Create or obtain existing Circuit Breaker
     *
     * Method MUST return existing circuit breaker instance, if one was previously
     * created for the given service (profile)
     *
     * @param string $service Name (profile) of Circuit Breaker to obtain or create
     * @param array $options [optional] Circuit Breaker options
     *
     * @return CircuitBreaker
     *
     * @throws ProfileNotFoundException
     */
    public function create(string $service, array $options = []): CircuitBreaker;

    /**
     * Creates a new store instance
     *
     * @param string $service Service name
     * @param class-string<Store>|null $driver [optional] Class path to store "driver". If none given,
     *                            then {@see defaultStore} is used.
     * @param array $options [optional] Store options
     *
     * @return Store
     */
    public function store(string $service, string|null $driver = null, array $options = []): Store;

    /**
     * Returns a default store
     *
     * @return class-string<Store> Class path
     */
    public function defaultStore(): string;
}
