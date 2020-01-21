<?php

namespace Aedart\Core\Providers;

use Aedart\Contracts\Exceptions\ExceptionHandler;
use Aedart\Core\Exceptions\Handlers\CompositeExceptionHandler;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Exception Handler Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Providers
 */
class ExceptionHandlerServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        ExceptionHandler::class      => CompositeExceptionHandler::class
    ];

    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes( [
            __DIR__ . '/../../../configs/exceptions.php' => config_path('exceptions.php')
        ],'config');
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [ ExceptionHandler::class ];
    }
}
