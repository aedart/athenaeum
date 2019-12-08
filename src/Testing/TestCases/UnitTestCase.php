<?php

namespace Aedart\Testing\TestCases;

use Aedart\Testing\TestCases\Partials\FakerPartial;
use Codeception\Actor;
use Codeception\TestCase\Test;
use \Mockery as m;

/**
 * Unit Test Case
 *
 * <br />
 *
 * Base test-case for codeception unit tests.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\TestCases
 */
abstract class UnitTestCase extends Test
{
    use FakerPartial;

    /**
     * @var \UnitTester|Actor
     */
    protected $tester;

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        $this->setupFaker();
    }

    /**
     * {@inheritdoc}
     */
    protected function _after()
    {
        m::close();
    }

    /*****************************************************************
     * Helpers and Utilities
     ****************************************************************/


}
