<?php

namespace Aedart\Contracts\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;

/**
 * Http Clients Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients
 */
interface Manager
{
    /**
     * Create or obtain a Http Client instance
     *
     * If client profile was previously instantiated, then this method will return the same
     * client instance. Use {@see fresh()} if you wish to obtain a new instance.
     *
     * @param string|null $profile [optional] Name of Http Client profile to obtain or create
     * @param array $options [optional] Http Client options
     *
     * @return Client
     *
     * @throws ProfileNotFoundException
     */
    public function profile(string|null $profile = null, array $options = []): Client;

    /**
     * Creates a new client instance for the given profile
     *
     * Unlike the {@see profile()} method, this method always returns a new client
     * instance.
     *
     * @param string|null $profile [optional] Name of Http Client profile to obtain or create
     * @param array $options [optional] Http Client options
     *
     * @return Client
     *
     * @throws ProfileNotFoundException
     */
    public function fresh(string|null $profile = null, array $options = []): Client;
}
