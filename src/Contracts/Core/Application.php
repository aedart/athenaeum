<?php

namespace Aedart\Contracts\Core;

use Aedart\Contracts\Container\IoC;
use Aedart\Contracts\Core\Helpers\CanBeBootstrapped;
use Illuminate\Contracts\Foundation\Application as LaravelApplication;
use Throwable;

/**
 * Application
 *
 * Adapted version of Laravel's Application
 *
 * @see \Illuminate\Contracts\Foundation\Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Core
 */
interface Application extends IoC,
    LaravelApplication
{
    /**
     * Determine if running in "local" environment
     *
     * @return bool
     */
    public function isLocal() : bool ;

    /**
     * Determine if running in "production" environment
     *
     * @return bool
     */
    public function isProduction() : bool ;

    /**
     * Determine if running in "testing" environment
     *
     * @return bool
     */
    public function isTesting() : bool ;

    /**
     * Determine if this application has booted
     *
     * @return bool
     */
    public function isBooted() : bool ;

    /**
     * Register a new terminating listener.
     *
     * @param callable $callback
     *
     * @return self
     */
    public function terminating(callable $callback);

    /**
     * Register a list of service providers
     *
     * Method will automatically determine if a service provider needs
     * to be registered normally (eager) or deferred.
     *
     * @see register
     * @see \Illuminate\Contracts\Support\DeferrableProvider
     *
     * @param \Illuminate\Support\ServiceProvider[]|string[] $providers
     *
     * @return self
     */
    public function registerMultipleServiceProviders(array $providers);

    /**
     * Determine if the application has bootstrapped it's
     * core bootstrappers and booted
     *
     * @see run
     * @see hasBeenBootstrapped
     * @see isBooted
     *
     * @return bool
     */
    public function isRunning() : bool ;

    /**
     * Bootstrap application's core bootstrappers and boot
     * all of it's registered service providers
     *
     * Method does nothing, if application is already running
     *
     * @param callable|null $callback [optional] Invoked after bootstrap and boot has completed
     *
     * @see isRunning
     * @see bootstrapWith
     * @see boot
     * @see getCoreBootstrappers
     * @see getCoreServiceProviders
     *
     * @throws Throwable
     */
    public function run(?callable $callback = null) : void ;

    /**
     * Get the application's core "bootstrappers"
     *
     * @return CanBeBootstrapped[]|string[] Instances or list of class paths
     */
    public function getCoreBootstrappers() : array ;

    /**
     * Get this application's core service providers.
     *
     * @return \Illuminate\Support\ServiceProvider[]|string[] Instances or list of class paths
     */
    public function getCoreServiceProviders() : array ;
}
