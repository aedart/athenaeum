<?php

namespace Aedart\Circuits\Providers;

use Aedart\Circuits\States\Factory;
use Aedart\Contracts\Circuits\States\Factory as StatesFactory;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Circuit Breaker Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Providers
 */
class CircuitBreakerServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        StatesFactory::class => Factory::class
    ];

    /**
     * Bootstrap this service
     */
//    public function boot()
//    {
//        $this->publishes([
//            __DIR__ . '/../../configs/circuit-breakers.php' => config_path('circuit-breakers.php')
//        ], 'config');
//    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            StatesFactory::class
        ];
    }
}
