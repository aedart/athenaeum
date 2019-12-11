<?php


namespace Aedart\Testing\TestCases;

use Aedart\Contracts\Core\Application;
use Aedart\Core\Application as CoreApplication;

/**
 * Application Integration Test Case
 *
 * Base test-case for integration tests, using an application
 *
 * @see \Aedart\Contracts\Core\Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\TestCases
 */
abstract class ApplicationIntegrationTestCase extends IntegrationTestCase
{
    /**
     * Application instance
     *
     * @var Application|null
     */
    protected ?Application $app = null;

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();

        // (Re)register container, use application
        // instead.
        $this->ioc->destroy();
        $this->ioc = CoreApplication::getInstance();
        $this->app = $this->ioc;
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

        parent::_after();
    }
}
