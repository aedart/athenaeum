<?php

namespace Aedart\Http\Api\Providers;

use Aedart\Contracts\Http\Api\Registrar as RegistrarInterface;
use Aedart\Http\Api\Registrar;
use Aedart\Http\Api\Traits\ApiResourceRegistrarTrait;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Support\ServiceProvider;

/**
 * Json Resource Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Providers
 */
class JsonResourceServiceProvider extends ServiceProvider
{
    use ConfigTrait;
    use ApiResourceRegistrarTrait;

    public array $singletons = [
        RegistrarInterface::class => Registrar::class
    ];

    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../configs/api-resources.php' => config_path('api-resources.php')
        ], 'config');

        // -------------------------------------------------------------------- //

        $langDir = __DIR__ . '/../../resources/lang';
        $this->loadTranslationsFrom($langDir, 'athenaeum-http-api');

        $this->publishes([
            $langDir => $this->app->langPath('vendor/athenaeum-http-api'),
        ]);

        // -------------------------------------------------------------------- //
        // Register api resources that are defined in configuration
        $this->getApiResourceRegistrar()->register(
            $this->getConfig()->get('api-resources.registry', [])
        );
    }
}
