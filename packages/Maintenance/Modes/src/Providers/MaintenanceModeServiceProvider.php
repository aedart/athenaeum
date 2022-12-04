<?php

namespace Aedart\Maintenance\Modes\Providers;

use Aedart\Maintenance\Modes\FallbackManager;
use Aedart\Maintenance\Modes\Traits\MaintenanceModeManagerTrait;
use Illuminate\Contracts\Foundation\MaintenanceMode;
use Illuminate\Support\ServiceProvider;

/**
 * Maintenance Mode Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Maintenance\Modes\Providers
 */
class MaintenanceModeServiceProvider extends ServiceProvider
{
    use MaintenanceModeManagerTrait;

    /**
     * Class patch to Laravel's default maintenance mode manager
     *
     * @var string
     */
    protected static string $laravelManager = 'Illuminate\Foundation\MaintenanceModeManager';

    /**
     * @inheritdoc
     */
    public function register()
    {
        $app = $this->app;

        // Favour Laravel's Maintenance mode manager, if available
        if ($app->bound(static::$laravelManager) && $app->bound(MaintenanceMode::class)) {
            $app->booting(function () {
                $this->installMaintenanceModes();
            });

            return;
        }

        // Otherwise, use the fallback maintenance mode manager.
        $app->singleton(static::$laravelManager, function () {
            return $this->createFallbackManager();
        });
        $app->alias(FallbackManager::class, static::$laravelManager);

        // Bind a default maintenance mode
        $app->bind(
            MaintenanceMode::class,
            fn () => $this->createFallbackManager()->driver()
        );
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Installs additional maintenance modes into Laravel's manager
     *
     * @return void
     */
    protected function installMaintenanceModes(): void
    {
        $manager = $this->getMaintenanceModeManager();

        $manager->extend('array', function () {
            return $this->createFallbackManager()->driver('array');
        });

        $manager->extend('json', function () {
            return $this->createFallbackManager()->driver('json');
        });
    }

    /**
     * Creates new fallback maintenance mode manager instance
     *
     * @return FallbackManager
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function createFallbackManager(): FallbackManager
    {
        return $this->app->make(FallbackManager::class);
    }
}
