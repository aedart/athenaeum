<?php

namespace Aedart\Flysystem\Db\Providers;

use Aedart\Flysystem\Db\Console\MakeAdapterMigrationCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Flysystem Database Adapter Service Provider
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Flysystem\Db\Providers
 */
class FlysystemDatabaseAdapterServiceProvider extends ServiceProvider
{
    /**
     * Boot this service
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeAdapterMigrationCommand::class
            ]);
        }
    }
}