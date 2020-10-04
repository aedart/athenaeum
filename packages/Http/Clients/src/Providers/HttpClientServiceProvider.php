<?php

namespace Aedart\Http\Clients\Providers;

use Aedart\Http\Messages\Providers\HttpSerializationServiceProvider;
use Illuminate\Support\AggregateServiceProvider;

/**
 * Http Client Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Providers
 */
class HttpClientServiceProvider extends AggregateServiceProvider
{
    /**
     * Providers for the Http Clients package.
     *
     * @var string[]
     */
    protected $providers = [
        ClientServiceProvider::class,
        HttpSerializationServiceProvider::class
    ];
}
