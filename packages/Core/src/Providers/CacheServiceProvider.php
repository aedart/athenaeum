<?php


namespace Aedart\Core\Providers;

use Illuminate\Cache\CacheManager;
use Illuminate\Cache\CacheServiceProvider as LaravelCacheServiceProvider;
use Illuminate\Cache\Console\ClearCommand;
use Illuminate\Cache\Console\ForgetCommand;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Contracts\Cache\Repository;
use Psr\SimpleCache\CacheInterface;

/**
 * Cache Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Providers
 */
class CacheServiceProvider extends LaravelCacheServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        parent::register();

        // Register a few aliases, which are needed by the "clear", "forget" and other
        // console commands.
        $this->app->alias('cache', Factory::class);
        $this->app->alias('cache', CacheManager::class);

        $this->app->alias('cache.store', Repository::class);
        $this->app->alias('cache.store', CacheInterface::class);
    }


    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this
            ->publishConfig()
            ->registerCommands();
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return array_merge(parent::provides(), [
            Factory::class,
            CacheManager::class,
        ]);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Registers console commands
     *
     * @return self
     */
    protected function registerCommands()
    {
        if (!$this->app->runningInConsole()) {
            return $this;
        }

        $this->commands([
            ClearCommand::class,
            ForgetCommand::class
        ]);

        return $this;
    }

    /**
     * Publish example configuration
     *
     * @return self
     */
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../../configs/cache.php' => config_path('cache.php')
        ], 'config');

        return $this;
    }
}
