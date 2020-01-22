<?php

namespace Aedart\Testing\TestCases;

use Aedart\Contracts\Core\Helpers\PathsContainer;
use Aedart\Core\Application as CoreApplication;
use Codeception\Configuration;
use Illuminate\Support\Env;

/**
 * Application Integration Test Case
 *
 * Base test-case for integration tests, using the custom adaptation of
 * Laravel's application
 *
 * @see \Aedart\Contracts\Core\Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\TestCases
 */
abstract class ApplicationTestCase extends IntegrationTestCase
{
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

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();

        // (Re)register container, use application
        // instead.
        $this->ioc->destroy();

        $this->app = $this->createApplication();
        $this->ioc = $this->app;

        Env::disablePutenv();
    }

    /**
     * @inheritdoc
     */
    protected function _after()
    {
        // Destroy application before destroying ioc
        if(isset($this->app)){
            $this->app->destroy();
            $this->app = null;
        }

        Env::enablePutenv();

        parent::_after();
    }

    /**
     * Creates a new application instance
     *
     * @see applicationPaths
     *
     * @param PathsContainer|array|null $paths [optional] Defaults to "application paths" if none given
     *
     * @return CoreApplication
     *
     * @throws \Throwable
     */
    protected function createApplication($paths = null)
    {
        // Resolve paths
        $paths = $paths ?? $this->applicationPaths();

        // Create application
        $app = new CoreApplication($paths, 'x.x.x-testing');

        // Detect "testing" environment
        $app->detectEnvironment(fn() => $this->detectEnvironment());

        // Final setup and return the instance
        return $app
            ->forceThrowExceptions($this->forceThrowExceptions);
    }

    /**
     * Returns the paths that the application must use
     *
     * @return array
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    protected function applicationPaths() : array
    {
        return [
            'basePath'          => getcwd(),
            'bootstrapPath'     => Configuration::dataDir() . 'bootstrap',
            'configPath'        => Configuration::dataDir() . 'config',
            'databasePath'      => Configuration::outputDir() . 'database',
            'environmentPath'   => getcwd(),
            'resourcePath'      => Configuration::dataDir() . 'resources',
            'storagePath'       => Configuration::dataDir()
        ];
    }

    /**
     * Detects the environment the application must use
     *
     * @return string
     */
    protected function detectEnvironment() : string
    {
        return 'testing';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

}
