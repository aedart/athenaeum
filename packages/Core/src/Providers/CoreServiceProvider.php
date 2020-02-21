<?php

namespace Aedart\Core\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Core Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Providers
 */
class CoreServiceProvider extends ServiceProvider
{
    /**
     * Boot this service provider
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../configs/app.php' => config_path('app.php'),
        ], 'config');
    }
}
