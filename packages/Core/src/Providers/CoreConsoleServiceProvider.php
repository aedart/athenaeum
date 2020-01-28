<?php

namespace Aedart\Core\Providers;

use Aedart\Console\Providers\ConsoleServiceProvider;
use Illuminate\Support\AggregateServiceProvider;

/**
 * Core Console Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Providers
 */
class CoreConsoleServiceProvider extends AggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        ArtisanServiceProvider::class,
        ConsoleServiceProvider::class
    ];
}
