<?php

namespace Aedart\Acl\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Acl Service Provider
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Acl\Providers
 */
class AclServiceProvider extends ServiceProvider
{
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
