<?php

namespace Aedart\Tests\Unit\Circuits\States;

use Aedart\Circuits\States\Factory;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\Factory as StatesFactory;
use Aedart\Testing\TestCases\UnitTestCase;

/**
 * FactoryTest
 *
 * @group circuits
 * @group circuits-states
 * @group circuits-states-factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Circuits\States
 */
class FactoryTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns new states factory instance
     *
     * @return StatesFactory
     */
    public function makeStatesFactory(): StatesFactory
    {
        return new Factory();
    }


    /*****************************************************************
     * Actual Test
     ****************************************************************/

    /**
     * @test
     */
    public function canObtainInstance()
    {
        $factory = $this->makeStatesFactory();

        $this->assertInstanceOf(StatesFactory::class, $factory);
    }

    /**
     * @test
     * @throws UnknownStateException
     */
    public function canCreateState()
    {
        $factory = $this->makeStatesFactory();

        $state = $factory->make(CircuitBreaker::OPEN);

        $this->assertInstanceOf(State::class, $state);
    }

    /**
     * @test
     * @throws UnknownStateException
     */
    public function failsWhenNoIdProvided()
    {
        $this->expectException(UnknownStateException::class);

        $this->makeStatesFactory()->makeByArray([]);
    }

    /**
     * @test
     *
     * @throws UnknownStateException
     */
    public function failsWhenIdIsUnknown()
    {
        $this->expectException(UnknownStateException::class);

        $this->makeStatesFactory()->make(9999);
    }
}
