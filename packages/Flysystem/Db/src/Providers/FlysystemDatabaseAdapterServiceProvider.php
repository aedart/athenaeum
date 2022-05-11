<?php

namespace Aedart\Flysystem\Db\Providers;

use Aedart\Flysystem\Db\Adapters\DatabaseAdapter;
use Aedart\Flysystem\Db\Console\MakeAdapterMigrationCommand;
use Aedart\Support\Helpers\Database\ConnectionResolverTrait;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

/**
 * Flysystem Database Adapter Service Provider
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Flysystem\Db\Providers
 */
class FlysystemDatabaseAdapterServiceProvider extends ServiceProvider
{
    use ConnectionResolverTrait;

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

        $this->enableAdapterAsStorageDriver();
    }

    /**
     * Enables Database Adapter as a Storage Driver
     *
     * @return void
     */
    protected function enableAdapterAsStorageDriver(): void
    {
        Storage::extend('database', function($app, array $settings) {
            // Resolve database connection
            $connection = $this
                ->getConnectionResolver()
                ->connection(data_get($settings, 'connection', 'mysql'));

            // Create and configure adapter
            $adapter = (new DatabaseAdapter(
                data_get($settings, 'files_table', 'files'),
                data_get($settings, 'contents_table', 'files_contents'),
                $connection,
            ))
                ->setHashAlgorithm(data_get($settings, 'hash_algo', 'sha256'))
                ->setPathPrefix(data_get($settings, 'path_prefix', ''));

            return new FilesystemAdapter(
                new Filesystem($adapter),
                $adapter,
                $settings
            );
        });
    }
}