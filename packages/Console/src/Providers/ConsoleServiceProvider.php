<?php

namespace Aedart\Console\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Console Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console\Providers
 */
class ConsoleServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes( [
            __DIR__ . '/../../configs/commands.php' => config_path('commands.php')
        ],'config');
    }
}
