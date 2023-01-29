<?php

namespace Aedart\Redmine\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Redmine Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Providers
 */
class RedmineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../configs/redmine.php' => config_path('redmine.php')
        ], 'config');
    }
}
