<?php

namespace Aedart\Testing\TestCases;

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

        $this->startApplication();
        $this->ioc = $this->app;
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

    /*****************************************************************
     * Helpers
     ****************************************************************/

}
