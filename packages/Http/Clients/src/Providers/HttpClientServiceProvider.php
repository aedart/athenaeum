<?php

namespace Aedart\Http\Clients\Providers;

use Aedart\Contracts\Http\Clients\Manager as HttpClientsManager;
use Aedart\Http\Clients\Manager;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Http Client Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Providers
 */
class HttpClientServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        HttpClientsManager::class => Manager::class
    ];

    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../../configs/http-clients.php' => config_path('http-clients.php')
        ], 'config');
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [ HttpClientsManager::class ];
    }
}
