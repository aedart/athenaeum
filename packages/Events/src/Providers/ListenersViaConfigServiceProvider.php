<?php

namespace Aedart\Events\Providers;

use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use Illuminate\Support\ServiceProvider;

/**
 * Listeners via Config Service Provider
 *
 * Registers event listeners and subscribers from configuration.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Events\Providers
 */
class ListenersViaConfigServiceProvider extends ServiceProvider
{
    use ConfigTrait;
    use DispatcherTrait;

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
        $list = $this->getConfig()->get('events.listeners', []);
        $dispatcher = $this->getDispatcher();

        foreach ($list as $event => $listeners){
            foreach ($listeners as $listener){
                $dispatcher->listen($event, $listener);
            }
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
            __DIR__ . '/../../configs/events.php' => config_path('events.php')
        ], 'config');

        return $this;
    }
}
