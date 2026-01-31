<?php

namespace Aedart\Tests\Unit\Circuits\States;

use Aedart\Circuits\States\Factory;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\Factory as StatesFactory;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * FactoryTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Circuits\States
 */
#[Group(
    'circuits',
    'circuits-states',
    'circuits-states-factory',
)]
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

    #[Test]
    public function canObtainInstance()
    {
        $factory = $this->makeStatesFactory();

        $this->assertInstanceOf(StatesFactory::class, $factory);
    }

    /**
     * @throws UnknownStateException
     */
    #[Test]
    public function canCreateState()
    {
        $factory = $this->makeStatesFactory();

        $state = $factory->make(CircuitBreaker::OPEN);

        $this->assertInstanceOf(State::class, $state);
    }

    /**
     * @throws UnknownStateException
     */
    #[Test]
    public function failsWhenNoIdProvided()
    {
        $this->expectException(UnknownStateException::class);

        $this->makeStatesFactory()->makeFromArray([]);
    }

    /**
     * @throws UnknownStateException
     */
    #[Test]
    public function failsWhenIdIsUnknown()
    {
        $this->expectException(UnknownStateException::class);

        $this->makeStatesFactory()->make(9999);
    }
}
