<?php

namespace Aedart\Core\Providers;

use Aedart\Console\Providers\ConsoleServiceProvider;
use Aedart\Contracts\Console\Kernel as ConsoleKernelInterface;
use Aedart\Contracts\Core\Application;
use Aedart\Core\Console\Kernel;
use Illuminate\Contracts\Console\Kernel as LaravelConsoleKernelInterface;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Artisan Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Providers
 */
class ArtisanServiceProvider extends ConsoleServiceProvider implements DeferrableProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        parent::register();

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
    public function provides()
    {
        return array_merge(parent::provides(), [
            ConsoleKernelInterface::class
        ]);
    }
}
