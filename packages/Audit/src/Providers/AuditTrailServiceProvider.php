<?php

namespace Aedart\Audit\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Audit Trail Service Provider
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Providers
 */
class AuditTrailServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../configs/audit-trail.php' => config_path('audit-trail.php')
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}