<?php

namespace Aedart\Testing\Laravel;

use Aedart\Testing\Laravel\Bootstrap\LoadSpecifiedConfiguration;
use Aedart\Testing\Laravel\Database\MigrateProcessor;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
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
     * Start the Laravel application
     *
     * <br />
     *
     * Method does not do anything, if application has already
     * been started.
     *
     * @return self
     */
    public function startApplication()
    {
        // Abort if already running
        if ($this->hasApplicationBeenStarted()) {
            return $this;
        }

        // Set the environment
        $this->setApplicationEnvironment($this->environment);

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
    protected function setApplicationEnvironment(string $environment)
    {
        putenv('APP_ENV=' . $environment);

        return $this;
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
    protected function resolveConfigurationLoaderBinding()
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
