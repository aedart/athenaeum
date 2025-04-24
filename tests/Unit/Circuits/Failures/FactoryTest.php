<?php

namespace Aedart\Tests\Unit\Circuits\Failures;

use Aedart\Circuits\Failures\Factory;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\Failures\Factory as FailureFactory;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * FactoryTest
 *
 * @group circuits
 * @group circuits-failure
 * @group circuits-failure-factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Circuits\Failures
 */
#[Group(
    'circuits',
    'circuits-failure',
    'circuits-failure-factory'
)]
class FactoryTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns new failure factory instance
     *
     * @return FailureFactory
     */
    public function makeFailureFactory(): FailureFactory
    {
        return new Factory();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    #[Test]
    public function canObtainInstance()
    {
        $factory = $this->makeFailureFactory();

        $this->assertInstanceOf(FailureFactory::class, $factory);
    }

    /**
     * @test
     */
    #[Test]
    public function canCreateFailure()
    {
        $factory = $this->makeFailureFactory();

        $failure = $factory->make();
        ConsoleDebugger::output($failure);

        $this->assertInstanceOf(Failure::class, $failure);
    }
}
