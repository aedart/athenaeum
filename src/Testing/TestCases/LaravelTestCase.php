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
        parent::_after();

        $this->stopApplication();
    }
}
