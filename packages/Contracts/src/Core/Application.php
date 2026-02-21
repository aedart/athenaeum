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
 * @template S of \Illuminate\Support\ServiceProvider
 *
 * @see \Illuminate\Contracts\Foundation\Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Core
 */
interface Application extends IoC,
    EnvironmentHandler,
    LaravelApplication
{
    /**
     * Determine if running in "local" environment
     *
     * @return bool
     */
    public function isLocal(): bool;

    /**
     * Determine if running in "production" environment
     *
     * @return bool
     */
    public function isProduction(): bool;

    /**
     * Determine if running in "testing" environment
     *
     * @return bool
     */
    public function isTesting(): bool;

    /**
     * Determine if this application has booted
     *
     * @return bool
     */
    public function isBooted(): bool;

    /**
     * Register a list of service providers
     *
     * Method will automatically determine if a service provider needs
     * to be registered normally (eager) or deferred.
     *
     * @see register
     * @see \Illuminate\Contracts\Support\DeferrableProvider
     *
     * @param array<S|class-string<S>> $providers
     *
     * @return self
     */
    public function registerMultipleServiceProviders(array $providers): static;

    /**
     * Get this application's deferred services
     *
     * @return array Key = service class path, value = service provider
     */
    public function getDeferredServices(): array;

    /**
     * Determine if given service is deferred
     *
     * @param string $service Class path or identifier
     *
     * @return bool
     */
    public function isDeferredService(string $service): bool;

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
    public function isRunning(): bool;

    /**
     * Bootstrap application's core bootstrappers and boot
     * all of it's registered service providers
     *
     * Method does nothing, if application is already running
     *
     * @param null|callable(static): void $callback [optional] Invoked after bootstrap and boot has completed
     *
     * @see isRunning
     * @see bootstrapWith
     * @see boot
     * @see getCoreBootstrappers
     * @see getCoreServiceProviders
     *
     * @throws Throwable
     */
    public function run(callable|null $callback = null): void;

    /**
     * Get the application's core "bootstrappers"
     *
     * @return array<CanBeBootstrapped|class-string<CanBeBootstrapped>> Instances or list of class paths
     */
    public function getCoreBootstrappers(): array;

    /**
     * Get this application's core service providers.
     *
     * @return array<S|class-string<S>> Instances or list of class paths
     */
    public function getCoreServiceProviders(): array;

    /**
     * Set the state of exception handling
     *
     * If set to true, exception handlers are bypassed and evt.
     * exceptions are allowed to bubble upwards when caught.
     *
     * @param bool $force
     *
     * @return self
     */
    public function forceThrowExceptions(bool $force);

    /**
     * Get the state of exception handling
     *
     * If set to true, exception handlers are bypassed and evt.
     * exceptions are allowed to bubble upwards when caught.
     *
     * @see forceThrowExceptions
     *
     * @return bool
     */
    public function mustThrowExceptions(): bool;
}
