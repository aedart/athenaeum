<?php

namespace Aedart\Http\Clients\Providers;

use Aedart\Contracts\Http\Clients\Manager as HttpClientsManager;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammars\Manager as HttpQueryGrammarsManager;
use Aedart\Http\Clients\Manager as ClientsManager;
use Aedart\Http\Clients\Requests\Query\Grammars\Manager as GrammarsManager;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * (Http) Client Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Providers
 */
class ClientServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        HttpClientsManager::class => ClientsManager::class,
        HttpQueryGrammarsManager::class => GrammarsManager::class
    ];

    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../configs/http-clients.php' => config_path('http-clients.php')
        ], 'config');
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [ HttpClientsManager::class, HttpQueryGrammarsManager::class ];
    }
}
