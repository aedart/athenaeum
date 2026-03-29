<?php

namespace Aedart\Testing\TestCases;

use Aedart\Testing\TestCases\Partials\FakerPartial;
use Codeception\Test\Unit;
use Mockery as m;

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
abstract class UnitTestCase extends Unit
{
    use FakerPartial;

    /**
     * The current tester
     *
     * @var mixed
     */
    protected mixed $tester;

    /**
     * {@inheritdoc}
     */
    protected function _before(): void
    {
        //        error_reporting(-1);
        //        ini_set('display_errors', true);

        $this->setupFaker();
    }

    /**
     * {@inheritdoc}
     */
    protected function _after(): void
    {
        m::close();
    }

    /*****************************************************************
     * Helpers and Utilities
     ****************************************************************/
}
