<?php

namespace Aedart\Testing\TestCases;

use Codeception\Actor;
use Codeception\TestCase\Test;
use Faker\Factory;
use Faker\Generator;
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
    /**
     * @var \UnitTester|Actor
     */
    protected $tester;

    /**
     * @var Generator
     */
    protected ?Generator $faker = null;

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        $this->faker = Factory::create();
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
