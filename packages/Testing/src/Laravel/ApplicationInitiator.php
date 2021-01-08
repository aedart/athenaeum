<?php

namespace Aedart\Testing\Laravel;

use Aedart\Testing\Laravel\Bootstrap\LoadSpecifiedConfiguration;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Orchestra\Testbench\Concerns\Testing;

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

        // Clear service container instance
        $this->app->setInstance(null);

        // Tear down test environment
        $this->tearDownTheTestEnvironment();

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
}
