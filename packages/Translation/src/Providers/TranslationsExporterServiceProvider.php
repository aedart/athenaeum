<?php

namespace Aedart\Translation\Providers;

use Aedart\Contracts\Translation\Exports\Manager as ManagerInterface;
use Aedart\Translation\Exports\Manager;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Contracts\Translation\Loader;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\ServiceProvider;

/**
 * Translations Exporter Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Providers
 */
class TranslationsExporterServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->singleton(ManagerInterface::class, function() {
            // Some translations paths are only resolved after the application's
            // translator instance has been resolved. So, to ensure that the loader
            // has correct paths, we attempt to resolve the loader from Laravel's
            // translator instance.

            /** @var Translator $translator */
            $translator = $this->app->make('translator');

            /** @var Loader $loader */
            $loader = method_exists($translator, 'getLoader')
                ? $translator->getLoader()
                : $this->app->make('translation.loader');

            return new Manager($loader);
        });
    }

    /**
     * Boots this service provider
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../configs/translations-exporter.php' => config_path('translations-exporter.php')
        ], 'config');
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [ ManagerInterface::class ];
    }
}