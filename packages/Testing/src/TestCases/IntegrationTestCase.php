<?php

namespace Aedart\Testing\TestCases;

use Aedart\Container\IoC;
use Aedart\Contracts\Container\IoC as IoCInterface;
use Aedart\Contracts\Core\Application;

/**
 * Integration Test Case
 *
 * <br />
 *
 * Base test-case for integration tests.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\TestCases
 */
abstract class IntegrationTestCase extends UnitTestCase
{
    /**
     * Service Container instance
     *
     * @var IoCInterface|Application|null
     */
    protected IoCInterface|Application|null $ioc = null;

    /**
     * If true, the Service Container instance
     * will automatically register as application.
     *
     * @see \Aedart\Container\IoC::registerAsApplication
     *
     * @var bool
     */
    protected bool $registerAsApplication = true;

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        parent::_before();

        $this->ioc = IoC::getInstance();

        if ($this->registerAsApplication) {
            $this->ioc->registerAsApplication();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function _after()
    {
        if (isset($this->ioc)) {
            $this->ioc->destroy();
            $this->ioc = null;
        }

        parent::_after();
    }

    /*****************************************************************
     * Helpers and Utilities
     ****************************************************************/
}
