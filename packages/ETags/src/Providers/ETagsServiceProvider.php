<?php

namespace Aedart\ETags\Providers;

use Aedart\Contracts\ETags\Factory as ETagGeneratorFactory;
use Aedart\ETags\Factory;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * ETags Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Providers
 */
class ETagsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        ETagGeneratorFactory::class => Factory::class,
    ];

    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../configs/etags.php' => config_path('etags.php')
        ], 'config');
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            ETagGeneratorFactory::class,
        ];
    }
}