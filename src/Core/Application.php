<?php

namespace Aedart\Core;

use Aedart\Container\IoC;
use Aedart\Contracts\Core\Application as ApplicationInterface;
use Aedart\Contracts\Core\Helpers\CanBeBootstrapped;
use Aedart\Contracts\Core\Helpers\NamespaceDetector as ApplicationNamespaceDetector;
use Aedart\Contracts\Core\Helpers\NamespaceDetectorAware;
use Aedart\Contracts\Core\Helpers\PathsContainer;
use Aedart\Contracts\Core\Helpers\PathsContainerAware;
use Aedart\Contracts\Service\Registrar as ServiceProviderRegistrar;
use Aedart\Contracts\Service\ServiceProviderRegistrarAware;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Core\Helpers\NamespaceDetector;
use Aedart\Core\Helpers\Paths;
use Aedart\Core\Traits\NamespaceDetectorTrait;
use Aedart\Core\Traits\PathsContainerTrait;
use Aedart\Events\Providers\EventServiceProvider;
use Aedart\Filesystem\Providers\NativeFilesystemServiceProvider;
use Aedart\Service\Registrar;
use Aedart\Service\Traits\ServiceProviderRegistrarTrait;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Closure;
use Illuminate\Contracts\Foundation\Application as LaravelApplicationInterface;
use Illuminate\Support\ServiceProvider;
use LogicException;
use Throwable;

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
    ServiceProviderRegistrarAware,
    ConfigAware,
    NamespaceDetectorAware
{
    use PathsContainerTrait;
    use ServiceProviderRegistrarTrait;
    use ConfigTrait;
    use NamespaceDetectorTrait;

    /**
     * Application's version
     *
     * @var string
     */
    protected string $version;

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
     * Callbacks to be invoked during termination
     *
     * @var callable[]
     */
    protected array $terminationCallbacks = [];

    /**
     * State whether or not this application has been bootstrapped
     *
     * @var bool
     */
    protected bool $hasBootstrapped = false;

    /**
     * Filename of the environment file to be used
     *
     * @var string
     */
    protected string $environmentFile = '.env';

    /**
     * Your application's namespace
     *
     * @var string|null
     */
    protected ?string $namespace = null;

    /**
     * Application constructor.
     *
     * @param PathsContainer|array|null $paths [optional] Application's core paths
     * @param string $version [optional] Application's version, e.g. '1.5.3'
     *
     * @throws Throwable
     */
    public function __construct($paths = null, string $version = '1.0.0')
    {
        $this->version = $version;

        $this
            ->resolveApplicationPaths($paths)
            ->registerMainBindings()
            ->setFacadeApplication()
            ->registerConfiguredProviders();
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
        if(count($environments) > 0){
            $search = is_array($environments) ? $environments : [ $environments ];

            return in_array($this['env'], $search);
        }

        return $this['env'];
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
        return $this->isTesting();
    }

    /**
     * @inheritDoc
     */
    public function isDownForMaintenance()
    {
        return file_exists($this->basePath('.down'));
    }

    /**
     * @inheritDoc
     */
    public function registerConfiguredProviders()
    {
        $coreProviders = $this->getCoreServiceProviders();

        foreach ($coreProviders as $serviceProvider){
            $this->register($serviceProvider);
        }
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

        // Invoke callbacks, if application has already booted...
        if($this->isBooted()){
            $this->invokeApplicationCallbacks($this->afterBootedCallbacks);
        }
    }

    /**
     * @inheritDoc
     */
    public function bootstrapWith(array $bootstrappers)
    {
        // Abort if already bootstrapped
        if($this->hasBootstrapped){
            return;
        }

        // Change bootstrapping state of application
        $this->hasBootstrapped = true;

        // Invoke the bootstrappers
        foreach ($bootstrappers as $bootstrapper){
            $this->invokeBootstrapper( $this->make($bootstrapper) );
        }
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
        return $this['env'] = $callback();
    }

    /**
     * @inheritDoc
     */
    public function environmentFile()
    {
        return $this->environmentFile;
    }

    /**
     * @inheritDoc
     */
    public function environmentFilePath()
    {
        return $this->getPathsContainer()->environmentPath( $this->environmentPath() );
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
        return $this->getConfig()->get('app.locale', 'en');
    }

    /**
     * @inheritDoc
     */
    public function getNamespace()
    {
        if(isset($this->namespace)){
            return $this->namespace;
        }

        return $this->namespace = $this->getNamespaceDetector()
            ->detect( $this->basePath('composer.json') );
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
        return $this->hasBootstrapped;
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
        $this->environmentFile = $file;

        return $this;
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
        $this->getConfig()->set('app.locale', $locale);
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
     * {@inheritDoc}
     *
     * NOTE: Terminate will trigger termination callbacks,
     * yet the application is NOT destroyed!
     *
     * @see destroy
     */
    public function terminate()
    {
        $this->invokeApplicationCallbacks($this->terminationCallbacks);
    }

    /*****************************************************************
     * Custom methods implementation
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function isLocal(): bool
    {
        return $this['env'] === 'local';
    }

    /**
     * @inheritDoc
     */
    public function isProduction(): bool
    {
        return $this['env'] === 'production';
    }

    /**
     * @inheritDoc
     */
    public function isTesting(): bool
    {
        return $this['env'] === 'testing';
    }

    /**
     * @inheritdoc
     */
    public function isBooted(): bool
    {
        $bootedProviders = $this->getServiceProviderRegistrar()->booted();

        return !empty($bootedProviders);
    }

    /**
     * @inheritdoc
     */
    public function terminating(callable $callback)
    {
        $this->terminationCallbacks[] = $callback;

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function isRunning(): bool
    {
        return $this->hasBeenBootstrapped() && $this->isBooted();
    }

    /**
     * @inheritDoc
     */
    public function run(?callable $callback = null): void
    {
        if($this->isRunning()){
            return;
        }

        try {
            $this->bootstrapWith( $this->getCoreBootstrappers() );

            $this->boot();

            $callback = $callback ?? fn() => null;
            $this->invokeApplicationCallbacks([ $callback ]);
        } catch (Throwable $e) {
            $this->handleException($e);
        }
    }

    /**
     * @inheritDoc
     */
    public function getCoreBootstrappers(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getCoreServiceProviders(): array
    {
        return [
            NativeFilesystemServiceProvider::class,
            EventServiceProvider::class
        ];
    }

    /**
     * @inheritdoc
     */
    public function destroy(): void
    {
        $this->beforeBootingCallbacks = [];
        $this->afterBootedCallbacks = [];
        $this->terminationCallbacks = [];
        $this->hasBootstrapped = false;

        $this->setServiceProviderRegistrar(null);
        $this->setPathsContainer(null);

        parent::destroy();
    }

    /**
     * @inheritdoc
     */
    public function registerMainBindings()
    {
        parent::registerMainBindings();

        $key = 'app';

        $this->alias($key, self::class);
        $this->alias($key, ApplicationInterface::class);
        $this->alias($key, LaravelApplicationInterface::class);

        return $this;
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

    /**
     * @inheritdoc
     */
    public function getDefaultNamespaceDetector(): ?ApplicationNamespaceDetector
    {
        return new NamespaceDetector();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Invokes bootstrap-able component.
     *
     * @param CanBeBootstrapped $bootstrapper
     */
    protected function invokeBootstrapper(CanBeBootstrapped $bootstrapper)
    {
        // This implementation is identical to how Laravel's bootstrapping
        // logic functions. We dispatch custom events for each bootstrapper.
        // @see https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Application.php#L212

        /** @var \Illuminate\Contracts\Events\Dispatcher $dispatcher */
        $dispatcher = $this['events'];
        $class = get_class($bootstrapper);

        // Dispatch "before" event
        $dispatcher->dispatch('bootstrapping: ' . $class, [$this]);

        // Bootstrap
        $bootstrapper->bootstrap($this);

        // Dispatch "after" event
        $dispatcher->dispatch('bootstrapped: ' . $class, [$this]);
    }

    /**
     * Resolves this application's paths from given argument
     *
     * @param null|PathsContainer|array $paths [optional]
     *
     * @throws Throwable If an invalid paths argument has been provided
     *
     * @return self
     */
    protected function resolveApplicationPaths($paths = null)
    {
        $this->tryPopulatePathsContainer($paths);

        $this->bindPaths();

        return $this;
    }

    /**
     * Attempts to populate the paths container from given argument
     *
     * @param null|PathsContainer|array $paths [optional]
     *
     * @throws Throwable If an invalid paths argument has been provided
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
     * Binds paths in the IoC service container
     */
    protected function bindPaths() : void
    {
        // Laravel uses the IoC to store paths, so that Services are able to
        // obtain them. Strictly speaking we could skip this, yet some service
        // providers use those bindings. Therefore, we bind some of those paths
        // here...
        // See https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Application.php#L285

        $this->instance('path.base', $this->basePath());
        $this->instance('path.bootstrap', $this->bootstrapPath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.environment', $this->environmentPath());
        $this->instance('path.resource', $this->resourcePath());
        $this->instance('path.storage', $this->storagePath());
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

    /**
     * Handles given exception
     *
     * @param Throwable $exception
     *
     * @throws Throwable
     */
    protected function handleException(Throwable $exception)
    {
        // TODO: Pass exception to "composite" exception handler
        // TODO: if possible...
        // TODO: ALSO - allow "force throw" exceptions... somehow!
        // TODO: For now, we simple just (re)throw the exception.
        throw $exception;
    }
}
