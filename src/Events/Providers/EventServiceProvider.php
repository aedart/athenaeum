<?php

namespace Aedart\Events\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherInterface;
use Illuminate\Events\Dispatcher;
use Illuminate\Events\EventServiceProvider as LaravelEventServiceProvider;

/**
 * Event Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Events\Providers
 */
class EventServiceProvider extends LaravelEventServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        parent::register();

        // Register aliases
        $key = 'events';

        $this->app->alias($key, Dispatcher::class);
        $this->app->alias($key, DispatcherInterface::class);
    }
}
