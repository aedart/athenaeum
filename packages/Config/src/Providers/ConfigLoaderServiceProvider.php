<?php

namespace Aedart\Config\Providers;

use Aedart\Config\Loader;
use Aedart\Config\Parsers\Factories\FileParserFactory;
use Aedart\Contracts\Config\Loader as LoaderInterface;
use Aedart\Contracts\Config\Parsers\Factories\FileParserFactory as FileParserFactoryInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Config Loader Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Providers
 */
class ConfigLoaderServiceProvider extends ServiceProvider
{
    /**
     * Register configuration loader service
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FileParserFactoryInterface::class, function(){
            return new FileParserFactory();
        });

        $this->app->singleton(LoaderInterface::class, function(){
            return new Loader();
        });
    }
}
