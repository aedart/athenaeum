<?php

namespace Aedart\Validation\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Validation Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Acl\Providers
 */
class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Boot this service
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'athenaeum-validation');

        $this->publishes([
            __DIR__ . '/../../resources/lang' => $this->app->langPath('vendor/athenaeum-validation'),
        ]);
    }
}
