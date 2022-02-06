<?php

namespace Aedart\Testing\TestCases;

use Aedart\Support\Helpers\Filesystem\FileTrait;
use Aedart\Testing\Athenaeum\AthenaeumTestHelper;
use Codeception\Configuration;

/**
 * Athenaeum Core Application Integration Test Case
 *
 * Base test-case for integration tests, using the custom adaptation of
 * Laravel's application
 *
 * @see \Aedart\Contracts\Core\Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\TestCases
 */
abstract class AthenaeumTestCase extends IntegrationTestCase
{
    use AthenaeumTestHelper;
    use FileTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();

        // Destroy Service Container, use application
        // instead.
        $this->ioc->destroy();

        $this->startApplication();
        $this->ioc = $this->app;

        // Ensure directory for default maintenance mode storage path!
        $maintenancePath = storage_path('framework');

        $fs = $this->getFile();
        $fs->ensureDirectoryExists($maintenancePath);
        $fs->cleanDirectory($maintenancePath);
    }

    /**
     * @inheritdoc
     */
    protected function _after()
    {
        // Destroy application before destroying ioc
        $this->stopApplication();

        parent::_after();
    }

    /**
     * @inheritdoc
     */
    protected function applicationPaths(): array
    {
        return [
            'basePath' => getcwd(),
            'bootstrapPath' => Configuration::dataDir() . 'bootstrap',
            'configPath' => Configuration::dataDir() . 'config',
            'databasePath' => Configuration::outputDir() . 'database',
            'environmentPath' => getcwd(),
            'resourcePath' => Configuration::dataDir() . 'resources',
            'storagePath' => Configuration::outputDir(),
            'publicPath' => Configuration::outputDir() . 'public'
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/
}
