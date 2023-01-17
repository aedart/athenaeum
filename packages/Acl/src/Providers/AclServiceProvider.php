<?php

namespace Aedart\Acl\Providers;

use Aedart\Acl\Registrar;
use Aedart\Contracts\Acl\Registrar as RegistrarInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Acl Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Acl\Providers
 */
class AclServiceProvider extends ServiceProvider
{
    public array $singletons = [
        RegistrarInterface::class => Registrar::class,
    ];

    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../configs/acl.php' => config_path('acl.php')
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
