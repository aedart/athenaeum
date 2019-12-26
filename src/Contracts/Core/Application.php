<?php

namespace Aedart\Contracts\Core;

use Aedart\Contracts\Container\IoC;
use Illuminate\Contracts\Foundation\Application as LaravelApplication;

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
     * Get this application's core service providers.
     *
     * Service Providers are automatically registered via
     * the "register configured providers" method.
     *
     * @see registerConfiguredProviders
     *
     * @return \Illuminate\Support\ServiceProvider[]|string[] Instances or list of class paths
     */
    public function getCoreServiceProviders() : array ;
}
