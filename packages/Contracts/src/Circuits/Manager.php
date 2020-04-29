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
     * Create or obtain Circuit Breaker
     *
     * @param string $name Name (profile) of Circuit Breaker to obtain or create
     * @param array $options [optional] Circuit Breaker options
     * @param bool $autoCreate [optional] When true, new circuit breaker is created, even
     *                       if a "profile" does not exist.
     *
     * @return CircuitBreaker
     *
     * @throws ProfileNotFoundException Only when `$autoCreate` is set to false and requested
     *                                  circuit breaker does not exist.
     */
    public function create(string $name, array $options = [], bool $autoCreate = false): CircuitBreaker;

    /**
     * Creates a new store instance
     *
     * @param string|null $driver [optional] Class path to store "driver". If none given,
     *                            then {@see defaultStore} is used.
     * @param array $options [optional] Store options
     *
     * @return Store
     */
    public function store($driver = null, array $options = []): Store;

    /**
     * Returns a default store
     *
     * @return Store
     */
    public function defaultStore(): Store;
}
