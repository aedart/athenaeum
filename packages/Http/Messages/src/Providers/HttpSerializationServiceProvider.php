<?php

namespace Aedart\Http\Messages\Providers;

use Aedart\Contracts\Http\Messages\Serializers\Factory as FactoryInterface;
use Aedart\Http\Messages\Serializers\Factory;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Http Serialization Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Messages\Providers
 */
class HttpSerializationServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        FactoryInterface::class => Factory::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [ FactoryInterface::class ];
    }
}
