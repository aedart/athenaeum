<?php

namespace Aedart\Core\Providers;

use Aedart\Contracts\Console\Kernel as ConsoleKernelInterface;
use Aedart\Contracts\Core\Application;
use Aedart\Core\Console\Commands\PublishCommand;
use Aedart\Core\Console\Kernel;
use Illuminate\Contracts\Console\Kernel as LaravelConsoleKernelInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Artisan Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Providers
 */
class ArtisanServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->singleton(
            ConsoleKernelInterface::class, function(){
            /** @var Application $core */
            $core = $this->app->make(Application::class);

            return new Kernel($core);
        });

        $this->app->alias(ConsoleKernelInterface::class, LaravelConsoleKernelInterface::class);
    }

    /**
     * @inheritdoc
     */
    public function boot()
    {
        if( ! $this->app->runningInConsole()){
            return;
        }

        $this->commands([
            PublishCommand::class
        ]);
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return [
            ConsoleKernelInterface::class
        ];
    }
}
