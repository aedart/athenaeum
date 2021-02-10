<?php

namespace Aedart\Testing\TestCases;

use Aedart\Testing\Laravel\LaravelTestHelper;

/**
 * Laravel Test Case
 *
 * <br />
 *
 * Codeception Laravel integration test-case.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\TestCases
 */
abstract class LaravelTestCase extends IntegrationTestCase
{
    use LaravelTestHelper;

    /**
     * WARNING: Whilst testing using this abstraction,
     * you should avoid allowing the Service Container
     * from the `IntegrationTestCase` to register as
     * "application" - it might cause unwanted behaviour!
     *
     * @var bool
     */
    protected bool $registerAsApplication = false;

    /*****************************************************************
     * Setup Methods
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        parent::_before();

        $this->startApplication();
    }

    /**
     * {@inheritdoc}
     */
    protected function _after()
    {
        $this->stopApplication();

        parent::_after();
    }
}
