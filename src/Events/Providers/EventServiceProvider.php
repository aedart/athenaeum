<?php

namespace Aedart\Events\Providers;

use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Events\DispatcherTrait;
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
    use ConfigTrait;
    use DispatcherTrait;

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

    /**
     * Boot this service
     */
    public function boot()
    {
        $this
            ->publishConfiguration()
            ->registerEventListener()
            ->registerSubscribers();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Register event listeners that are defined in configuration
     *
     * @return self
     */
    protected function registerEventListener()
    {
        $listeners = $this->getConfig()->get('events.listeners', []);
        $dispatcher = $this->getDispatcher();

        foreach ($listeners as $event => $listener){
            $dispatcher->listen($event, $listener);
        }

        return $this;
    }

    /**
     * Register event subscribers that are defined in configuration
     *
     * @return self
     */
    protected function registerSubscribers()
    {
        $subscribers = $this->getConfig()->get('events.subscribers', []);
        $dispatcher = $this->getDispatcher();

        foreach ($subscribers as $subscriber){
            $dispatcher->subscribe($subscriber);
        }

        return $this;
    }

    /**
     * Register configuration to be published
     *
     * @return self
     */
    protected function publishConfiguration()
    {
        $this->publishes([
            __DIR__ . '/../../../configs/events.php' => config_path('events.php')
        ], 'config');

        return $this;
    }
}
