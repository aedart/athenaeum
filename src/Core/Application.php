<?php

namespace Aedart\Core;

use Aedart\Container\IoC;
use Aedart\Contracts\Core\Application as ApplicationInterface;
use Aedart\Contracts\Service\Registrar as ServiceProviderRegistrar;
use Aedart\Service\Registrar;
use Aedart\Service\Traits\ServiceProviderRegistrarTrait;
use Closure;

/**
 * Application
 *
 * @see \Aedart\Contracts\Core\Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core
 */
class Application extends IoC implements ApplicationInterface
{
    use ServiceProviderRegistrarTrait;

    // TODO: Implement constructor
    public function __construct()
    {

    }

    /**
     * @inheritDoc
     */
    public function version()
    {
        // TODO: Implement version() method.
    }

    /**
     * @inheritDoc
     */
    public function basePath($path = '')
    {
        // TODO: Implement basePath() method.
    }

    /**
     * @inheritDoc
     */
    public function bootstrapPath($path = '')
    {
        // TODO: Implement bootstrapPath() method.
    }

    /**
     * @inheritDoc
     */
    public function configPath($path = '')
    {
        // TODO: Implement configPath() method.
    }

    /**
     * @inheritDoc
     */
    public function databasePath($path = '')
    {
        // TODO: Implement databasePath() method.
    }

    /**
     * @inheritDoc
     */
    public function environmentPath()
    {
        // TODO: Implement environmentPath() method.
    }

    /**
     * @inheritDoc
     */
    public function resourcePath($path = '')
    {
        // TODO: Implement resourcePath() method.
    }

    /**
     * @inheritDoc
     */
    public function storagePath()
    {
        // TODO: Implement storagePath() method.
    }

    /**
     * @inheritDoc
     */
    public function environment(...$environments)
    {
        // TODO: Implement environment() method.
    }

    /**
     * @inheritDoc
     */
    public function runningInConsole()
    {
        // TODO: Implement runningInConsole() method.
    }

    /**
     * @inheritDoc
     */
    public function runningUnitTests()
    {
        // TODO: Implement runningUnitTests() method.
    }

    /**
     * @inheritDoc
     */
    public function isDownForMaintenance()
    {
        // TODO: Implement isDownForMaintenance() method.
    }

    /**
     * @inheritDoc
     */
    public function registerConfiguredProviders()
    {
        // TODO: Implement registerConfiguredProviders() method.
    }

    /**
     * @inheritDoc
     *
     * @param  \Illuminate\Support\ServiceProvider|string  $provider
     * @param bool $force [optional] Force argument ignored!
     */
    public function register($provider, $force = false)
    {
        // Register provider. Boot if needed
        $registrar = $this->getServiceProviderRegistrar();
        $registrar->register($provider, $this->isBooted());

        // Obtain last registered provider, return it.
        $providers = $registrar->providers();

        return array_pop($providers);
    }

    /**
     * @inheritDoc
     */
    public function registerDeferredProvider($provider, $service = null)
    {
        // TODO: Implement registerDeferredProvider() method.
    }

    /**
     * @inheritDoc
     */
    public function resolveProvider($provider)
    {
        return $this->getServiceProviderRegistrar()->resolveProvider($provider);
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }

    /**
     * @inheritDoc
     */
    public function booting($callback)
    {
        // TODO: Implement booting() method.
    }

    /**
     * @inheritDoc
     */
    public function booted($callback)
    {
        // TODO: Implement booted() method.
    }

    /**
     * @inheritDoc
     */
    public function bootstrapWith(array $bootstrappers)
    {
        // TODO: Implement bootstrapWith() method.
    }

    /**
     * @inheritDoc
     */
    public function configurationIsCached()
    {
        // TODO: Implement configurationIsCached() method.
    }

    /**
     * @inheritDoc
     */
    public function detectEnvironment(Closure $callback)
    {
        // TODO: Implement detectEnvironment() method.
    }

    /**
     * @inheritDoc
     */
    public function environmentFile()
    {
        // TODO: Implement environmentFile() method.
    }

    /**
     * @inheritDoc
     */
    public function environmentFilePath()
    {
        // TODO: Implement environmentFilePath() method.
    }

    /**
     * @inheritDoc
     */
    public function getCachedConfigPath()
    {
        // TODO: Implement getCachedConfigPath() method.
    }

    /**
     * @inheritDoc
     */
    public function getCachedServicesPath()
    {
        // TODO: Implement getCachedServicesPath() method.
    }

    /**
     * @inheritDoc
     */
    public function getCachedPackagesPath()
    {
        // TODO: Implement getCachedPackagesPath() method.
    }

    /**
     * @inheritDoc
     */
    public function getCachedRoutesPath()
    {
        // TODO: Implement getCachedRoutesPath() method.
    }

    /**
     * @inheritDoc
     */
    public function getLocale()
    {
        // TODO: Implement getLocale() method.
    }

    /**
     * @inheritDoc
     */
    public function getNamespace()
    {
        // TODO: Implement getNamespace() method.
    }

    /**
     * @inheritDoc
     */
    public function getProviders($provider)
    {
        return $this->getServiceProviderRegistrar()->getProviders($provider);
    }

    /**
     * @inheritDoc
     */
    public function hasBeenBootstrapped()
    {
        // TODO: Implement hasBeenBootstrapped() method.
    }

    /**
     * @inheritDoc
     */
    public function loadDeferredProviders()
    {
        // TODO: Implement loadDeferredProviders() method.
    }

    /**
     * @inheritDoc
     */
    public function loadEnvironmentFrom($file)
    {
        // TODO: Implement loadEnvironmentFrom() method.
    }

    /**
     * @inheritDoc
     */
    public function routesAreCached()
    {
        // TODO: Implement routesAreCached() method.
    }

    /**
     * @inheritDoc
     */
    public function setLocale($locale)
    {
        // TODO: Implement setLocale() method.
    }

    /**
     * @inheritDoc
     */
    public function shouldSkipMiddleware()
    {
        // TODO: Implement shouldSkipMiddleware() method.
    }

    /**
     * @inheritDoc
     */
    public function terminate()
    {
        // TODO: Implement terminate() method.
    }

    /*****************************************************************
     * Custom methods implementation
     ****************************************************************/

    /**
     * @inheritdoc
     */
    public function isBooted(): bool
    {
        $bootedProviders = $this->getServiceProviderRegistrar()->booted();

        return !empty($bootedProviders);
    }

    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * @inheritdoc
     */
    public function getDefaultServiceProviderRegistrar(): ?ServiceProviderRegistrar
    {
        return new Registrar($this);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/


}
