<?php

namespace Aedart\Testing\Laravel;

use Aedart\Testing\Laravel\Bootstrap\LoadSpecifiedConfiguration;
use Aedart\Testing\Laravel\Database\MigrateProcessor;
use Aedart\Utils\Str;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Orchestra\Testbench\Concerns\Testing;
use Orchestra\Testbench\Foundation\PackageManifest;

/**
 * Application Initiator
 *
 * <br />
 *
 * Allows you to start and stop the Laravel application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Laravel
 */
trait ApplicationInitiator
{
    use Testing;

    /**
     * Environment name
     *
     * @see setApplicationEnvironment()
     *
     * @var string
     */
    protected string $environment = 'testing';

    /**
     * When true, APP_KEY environment variable is
     * generated and set.
     *
     * @var bool
     */
    protected bool $mustGenerateAppKey = false;

    /**
     * Automatically enables package discoveries.
     *
     * @see ignorePackageDiscoveriesFrom
     *
     * @var bool
     */
    protected bool $enablesPackageDiscoveries = false;

    /**
     * Start the Laravel application
     *
     * <br />
     *
     * Method does not do anything, if application has already
     * been started.
     *
     * @return self
     */
    public function startApplication(): static
    {
        // Abort if already running
        if ($this->hasApplicationBeenStarted()) {
            return $this;
        }

        // Set the environment and application key
        $this->setApplicationEnvironment($this->environment);
        if ($this->mustGenerateAppKey) {
            $key = $this->generateAppKey();
            $this->setAppKeyEnvironmentVariable($key);
        }

        // Setup test environment
        $this->setUpTheTestEnvironment();

        return $this;
    }

    /**
     * Stops the Laravel application
     *
     * <br />
     *
     * If application was already stopped, then this method will
     * not do anything.
     *
     * @return bool
     */
    public function stopApplication(): bool
    {
        if (!$this->hasApplicationBeenStarted()) {
            return false;
        }

        // Tear down test environment
        $this->tearDownTheTestEnvironment();

        // Empty evt. paths to be published, or we risk that when a publish
        // command is invoked, unintended resources are published.
        ServiceProvider::$publishes = [];

        // Clear the service container's own instance, which
        // is set to Laravel's Application at this point.
        Container::setInstance(null);

        // Clear Facade instances
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication(null);

        return true;
    }

    /**
     * Returns the Laravel application
     *
     * @return Application|null
     */
    public function getApplication(): ?Application
    {
        return $this->app;
    }

    /**
     * Determine if the Laravel application has been started
     *
     * @return bool
     */
    public function hasApplicationBeenStarted(): bool
    {
        return isset($this->app);
    }

    /**
     * Returns path to configuration files to be loaded
     *
     * @return string
     */
    public function getConfigPath(): string
    {
        return $this->getBasePath() . '/config';
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function getEnvironmentSetUp($app)
    {
        // Define your environment setup
    }

    /**
     * Boot the testing helper traits.
     *
     * @return array
     */
    protected function setUpTraits()
    {
        $uses = array_flip(class_uses_recursive(static::class));

        return $this->setUpTheTestEnvironmentTraits($uses);
    }

    /**
     * @inheritdoc
     */
    protected function setUpTheTestEnvironmentTraitToBeIgnored(string $use): bool
    {
        return false;
    }

    /**
     * Refresh the application instance.
     *
     * @return void
     */
    protected function refreshApplication()
    {
        $this->app = $this->createApplication();
    }

    /**
     * Set the environment name
     *
     * @param string $environment Name of environment
     *
     * @return self
     */
    protected function setApplicationEnvironment(string $environment): static
    {
        putenv('APP_ENV=' . $environment);

        return $this;
    }

    /**
     * Sets the APP_KEY environment variable
     *
     * @param  string  $key
     *
     * @return self
     */
    protected function setAppKeyEnvironmentVariable(string $key): static
    {
        // Debug
        //        ConsoleDebugger::output('APP_KEY = ' . $key);

        putenv('APP_KEY=' . $key);

        return $this;
    }

    /**
     * Set whether value for APP_KEY environment must be generated, or not
     *
     * @param  bool  $generate  [optional]
     *
     * @return self
     */
    public function mustGenerateAppKey(bool $generate = true): static
    {
        $this->mustGenerateAppKey = $generate;

        return $this;
    }

    /**
     * Generates a new application key
     *
     * @return string
     */
    protected function generateAppKey(): string
    {
        return Str::random(32);
    }

    /**
     * Resolve application implementation.
     *
     * @return Application
     */
    protected function resolveApplication()
    {
        return tap(new Application($this->getBasePath()), function ($app) {
            $app->bind(
                'Illuminate\Foundation\Bootstrap\LoadConfiguration',
                $this->resolveConfigurationLoaderBinding()
            );

            PackageManifest::swap($app, $this);
        });
    }

    /**
     * Returns configuration loader 'bootstrapper' binding
     *
     * @return Closure|string|null
     */
    protected function resolveConfigurationLoaderBinding(): Closure|string|null
    {
        return function () {
            return (new LoadSpecifiedConfiguration())
                ->setConfigurationPath($this->getConfigPath());
        };
    }

    /**
     * @inheritdoc
     */
    protected function loadMigrationsFrom($paths): void
    {
        $options = \is_array($paths) ? $paths : ['--path' => $paths];

        if (isset($options['--realpath']) && !\is_bool($options['--realpath'])) {
            throw new InvalidArgumentException('Expect --realpath to be a boolean.');
        }

        $options['--realpath'] = true;

        $this->performMigration($options);
    }

    /**
     * @inheritdoc
     */
    protected function loadLaravelMigrations($database = []): void
    {
        $options = \is_array($database) ? $database : ['--database' => $database];

        $options['--path'] = 'migrations';

        $this->performMigration($options);
    }

    /**
     * @inheritdoc
     */
    protected function runLaravelMigrations($database = []): void
    {
        $options = \is_array($database) ? $database : ['--database' => $database];

        $this->performMigration($options);
    }

    /**
     * Runs the migrations
     *
     * @param array $options [optional]
     */
    protected function performMigration(array $options = [])
    {
        $migrator = $this->makeMigratorProcessor($options);
        $migrator->up();

        $this->resetApplicationArtisanCommands($this->app);

        $this->beforeApplicationDestroyed(static function () use ($migrator) {
            $migrator->rollback();
        });
    }

    /**
     * Creates a new custom migrate processor instance
     *
     * @param array $options [optional]
     *
     * @return MigrateProcessor
     */
    protected function makeMigratorProcessor(array $options = []): MigrateProcessor
    {
        return new MigrateProcessor($this, $options);
    }
}
