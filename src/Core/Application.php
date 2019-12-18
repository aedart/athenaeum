<?php

namespace Aedart\Core;

use Aedart\Container\IoC;
use Aedart\Contracts\Core\Application as ApplicationInterface;
use Aedart\Contracts\Core\Helpers\PathsContainer;
use Aedart\Contracts\Core\Helpers\PathsContainerAware;
use Aedart\Contracts\Service\Registrar as ServiceProviderRegistrar;
use Aedart\Contracts\Service\ServiceProviderRegistrarAware;
use Aedart\Core\Helpers\Paths;
use Aedart\Core\Traits\PathsContainerTrait;
use Aedart\Service\Registrar;
use Aedart\Service\Traits\ServiceProviderRegistrarTrait;
use Closure;
use Illuminate\Support\ServiceProvider;
use LogicException;

/**
 * Application
 *
 * @see \Aedart\Contracts\Core\Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core
 */
class Application extends IoC implements ApplicationInterface,
    PathsContainerAware,
    ServiceProviderRegistrarAware
{
    use PathsContainerTrait;
    use ServiceProviderRegistrarTrait;

    /**
     * Application's version
     *
     * @var string|null
     */
    protected ?string $version = null;

    /**
     * Callbacks to be invoked before booting
     *
     * @var callable[]
     */
    protected array $beforeBootingCallbacks = [];

    /**
     * Callbacks to be invoked after booted
     *
     * @var callable[]
     */
    protected array $afterBootedCallbacks = [];

    /**
     * Application constructor.
     *
     * @param PathsContainer|array|null $paths [optional] Application's core paths
     * @param string|null $version [optional] Application's version, e.g. '1.5.3'
     *
     * @throws \Throwable
     */
    public function __construct($paths = null, ?string $version = '1.0.0')
    {
        $this->version = $version;

        $this->resolveApplicationPaths($paths);
    }

    /**
     * @inheritDoc
     */
    public function version()
    {
        return $this->version;
    }

    /**
     * @inheritDoc
     */
    public function basePath($path = '')
    {
        return $this->getPathsContainer()->basePath($path);
    }

    /**
     * @inheritDoc
     */
    public function bootstrapPath($path = '')
    {
        return $this->getPathsContainer()->bootstrapPath($path);
    }

    /**
     * @inheritDoc
     */
    public function configPath($path = '')
    {
        return $this->getPathsContainer()->configPath($path);
    }

    /**
     * @inheritDoc
     */
    public function databasePath($path = '')
    {
        return $this->getPathsContainer()->databasePath($path);
    }

    /**
     * @inheritDoc
     */
    public function environmentPath()
    {
        return $this->getPathsContainer()->environmentPath();
    }

    /**
     * @inheritDoc
     */
    public function resourcePath($path = '')
    {
        return $this->getPathsContainer()->resourcePath($path);
    }

    /**
     * @inheritDoc
     */
    public function storagePath()
    {
        return $this->getPathsContainer()->storagePath();
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
        return in_array(php_sapi_name(), ['cli', 'phpdbg']);
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
     * @param  ServiceProvider|string  $provider
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
        // Abort if already booted
        if($this->isBooted()){
            return;
        }

        // Invoke "before" callbacks
        $this->invokeApplicationCallbacks($this->beforeBootingCallbacks);

        // Boot all registered service providers
        $this->getServiceProviderRegistrar()->bootAll();

        // Invoke "after" callbacks
        $this->invokeApplicationCallbacks($this->afterBootedCallbacks);
    }

    /**
     * @inheritDoc
     */
    public function booting($callback)
    {
        $this->beforeBootingCallbacks[] = $callback;
    }

    /**
     * @inheritDoc
     */
    public function booted($callback)
    {
        $this->afterBootedCallbacks[] = $callback;

        // Invoke callbacks, if application has already
        // booted...
        if($this->isBooted()){
            $this->invokeApplicationCallbacks($this->afterBootedCallbacks);
        }
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
        // By default, this application does not cache configuration.
        return false;
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
        // Not used by this application - overwrite if required
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getCachedServicesPath()
    {
        // Not used by this application - overwrite if required
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getCachedPackagesPath()
    {
        // Not used by this application - overwrite if required
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getCachedRoutesPath()
    {
        // Not used by this application - overwrite if required
        return '';
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
        // By default, this application does not offer routing
        return false;
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
        // By default, this application does not offer routing or
        // PSR middleware.
        return false;
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
    public function getDefaultPathsContainer(): ?PathsContainer
    {
        return new Paths([], $this);
    }

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

    /**
     * Resolves this application's paths from given argument
     *
     * @param null|PathsContainer|array $paths [optional]
     *
     * @throws \Throwable If an invalid paths argument has been provided
     */
    protected function resolveApplicationPaths($paths = null) : void
    {
        $this->tryPopulatePathsContainer($paths);

        // TODO: Bind paths in container... some services depend on this!
    }

    /**
     * Attempts to populate the paths container from given argument
     *
     * @param null|PathsContainer|array $paths [optional]
     *
     * @throws \Throwable If an invalid paths argument has been provided
     */
    protected function tryPopulatePathsContainer($paths = null)
    {
        // If nothing given, set and get default paths
        if( ! isset($paths)){
            $this->getPathsContainer();
            return;
        }

        // If array of paths has been given, populate paths container
        if(is_array($paths)){
            $this->getPathsContainer()->populate($paths);
            return;
        }

        // If a paths container has been provided, use it
        if($paths instanceof PathsContainer){
            $this->setPathsContainer($paths);
            return;
        }

        // Lastly, an invalid paths argument has been provide...
        throw new LogicException('Paths must either be a valid "Paths Container" instance, an "array" of paths or "null"');
    }

    /**
     * Invokes given list of callbacks
     *
     * @param callable[] $callbacks
     */
    protected function invokeApplicationCallbacks(array $callbacks)
    {
        // This method corresponds directly to Laravel's fireAppCallbacks
        // @see https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Application.php#L865
        foreach ($callbacks as $callback){
            $callback($this);
        }
    }
}
