<?php

namespace Aedart\Testing\Athenaeum;

use Aedart\Contracts\Core\Application;
use Aedart\Contracts\Core\Helpers\PathsContainer;
use Aedart\Core\Application as CoreApplication;
use Illuminate\Support\Env;
use Throwable;

/**
 * Application Initiator
 *
 * Allows you to start and stop the "adapted version of Laravel's Application"
 *
 * @see Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Athenaeum
 */
trait ApplicationInitiator
{
    use HandlesApplicationCallbacks;

    /**
     * Application instance
     *
     * @var CoreApplication|null
     */
    protected ?CoreApplication $app = null;

    /**
     * State of application's exception handling.
     *
     * @var bool
     */
    protected bool $forceThrowExceptions = true;

    /**
     * Start the application
     *
     * Method does not do anything, if application has already
     * been started.
     *
     * @return self
     *
     * @throws Throwable
     */
    public function startApplication()
    {
        if ($this->hasApplicationBeenStarted()) {
            return $this;
        }

        Env::disablePutenv();

        $this->app = $this->createApplication();

        $this->invokeAfterCreatedCallbacks();

        return $this;
    }

    /**
     * Stop the application
     *
     * Method does not do anything, if application has already been
     * stopped.
     *
     * Here the term "stopped" means that the application instance
     * is destroyed!
     *
     * @see \Aedart\Contracts\Core\Application::destroy
     *
     * @return bool
     */
    public function stopApplication(): bool
    {
        if (!$this->hasApplicationBeenStarted()) {
            return false;
        }

        $this->invokeBeforeDestroyedCallbacks();

        $this->app->destroy();
        $this->app = null;

        Env::enablePutenv();

        return true;
    }

    /**
     * Returns the adapted Laravel application
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

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Creates a new application instance
     *
     * @see applicationPaths
     *
     * @param PathsContainer|array|null $paths [optional] Defaults to "application paths" if none given
     *
     * @return CoreApplication
     *
     * @throws Throwable
     */
    protected function createApplication($paths = null)
    {
        // Resolve paths
        $paths = $paths ?? $this->applicationPaths();

        // Create application
        $app = new CoreApplication($paths, 'x.x.x-testing');

        // Detect "testing" environment
        $app->detectEnvironment(fn () => $this->detectEnvironment());

        // Final setup and return the instance
        return $app
            ->forceThrowExceptions($this->forceThrowExceptions);
    }

    /**
     * Returns the paths that the application must use
     *
     * @return array
     */
    protected function applicationPaths(): array
    {
        $root = getcwd() . DIRECTORY_SEPARATOR . 'testing';

        return [
            'basePath' => $root,
            'bootstrapPath' => $root . DIRECTORY_SEPARATOR . 'bootstrap',
            'configPath' => $root . DIRECTORY_SEPARATOR . 'config',
            'databasePath' => $root . DIRECTORY_SEPARATOR . 'database',
            'environmentPath' => $root,
            'resourcePath' => $root . DIRECTORY_SEPARATOR . 'resources',
            'storagePath' => $root . DIRECTORY_SEPARATOR . 'storage',
            'publicPath' => $root . DIRECTORY_SEPARATOR . 'public',
        ];
    }

    /**
     * Detects the environment the application must use
     *
     * @return string
     */
    protected function detectEnvironment(): string
    {
        return 'testing';
    }
}
