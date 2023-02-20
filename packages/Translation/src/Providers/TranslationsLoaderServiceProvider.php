<?php

namespace Aedart\Translation\Providers;

use Aedart\Contracts\Translation\TranslationsLoader;
use Aedart\Translation\Loaders\RawTranslationsLoader;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Contracts\Translation\Loader;
use Illuminate\Support\ServiceProvider;

/**
 * Translations Loader Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Providers
 */
class TranslationsLoaderServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->singleton(TranslationsLoader::class, function() {
            // Some translation paths are only resolved after the application's
            // translator has been resolved. Therefore, we obtain the translator
            // instance to trigger paths registration behaviour.
            // @see \Illuminate\Support\ServiceProvider::loadTranslationsFrom
            // @see \Illuminate\Support\ServiceProvider::loadJsonTranslationsFrom
            $translator = app()->make('translator');

            /** @var Loader $nativeLoader */
            $nativeLoader = method_exists($translator, 'getLoader')
                ? $translator->getLoader()
                : app()->make('translation.loader');

            return new RawTranslationsLoader(
                nativeLoader: $nativeLoader,
                paths: [
                    app()->langPath(),
                    ...config()->get('translations-loader.paths', [])
                ]
            );
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
            __DIR__ . '/../../configs/translations-loader.php' => config_path('translations-loader.php')
        ], 'config');
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [ TranslationsLoader::class ];
    }
}