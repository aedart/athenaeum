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
     * Create or obtain a Http Client
     *
     * @param string|null $profile [optional] Name of Http Client profile to obtain or create
     * @param array $options [optional] Http Client options
     *
     * @return Client
     *
     * @throws ProfileNotFoundException
     */
    public function profile(?string $profile = null, array $options = []) : Client ;
}