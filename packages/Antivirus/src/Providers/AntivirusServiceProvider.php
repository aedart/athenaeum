<?php

namespace Aedart\Antivirus\Providers;

use Aedart\Antivirus\DefaultUserResolver;
use Aedart\Contracts\Antivirus\UserResolver;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Antivirus Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Providers
 */
class AntivirusServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Singleton bindings
     *
     * @var array
     */
    public array $singletons = [
        UserResolver::class => DefaultUserResolver::class
    ];

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            UserResolver::class
        ];
    }
}