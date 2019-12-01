<?php

namespace Aedart\Testing\TestCases;

use Aedart\Container\IoC;
use Aedart\Contracts\Container\IoC as IoCInterface;

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
     * @var IoCInterface|null
     */
    protected ?IoCInterface $ioc;

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        parent::_before();

        $this->ioc = IoC::getInstance();
    }

    /**
     * {@inheritdoc}
     */
    protected function _after()
    {
        if(isset($this->ioc)){
            $this->ioc->destroy();
            $this->ioc = null;
        }

        parent::_after();
    }

    /*****************************************************************
     * Helpers and Utilities
     ****************************************************************/
}
