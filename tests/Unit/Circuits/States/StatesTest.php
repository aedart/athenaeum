<?php

namespace Aedart\Tests\Unit\Circuits\States;

use Aedart\Circuits\States\ClosedState;
use Aedart\Circuits\States\HalfOpenState;
use Aedart\Circuits\States\OpenState;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\State;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use DateTimeInterface;
use Illuminate\Support\Facades\Date;
use JsonException;
use PHPUnit\Framework\Attributes\Test;

/**
 * StatesTest
 *
 * @group circuits
 * @group circuits-states
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Circuits\States
 */
#[Group(
    'circuits',
    'circuits-states',
)]
class StatesTest extends UnitTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides state instances
     *
     * @return array[]
     */
    public function providesStates(): array
    {
        return [
            'closed' => [ ClosedState::make() ],
            'open' => [ OpenState::make() ],
            'half open' => [ HalfOpenState::make() ],
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns a random state identifier
     *
     * @return int
     *
     * @throws UnknownStateException
     */
    public function randomStateId(): int
    {
        return $this->getFaker()->randomElement(
            array_keys(ClosedState::make()->validStates())
        );
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesStates
     *
     * @param mixed $state
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canCreateInstance($state)
    {
        $this->assertInstanceOf(State::class, $state);
    }

    /**
     * @test
     * @dataProvider providesStates
     *
     * @param State $state
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function hasIdentifierAndName($state)
    {
        $id = $state->id();
        $name = $state->name();

        ConsoleDebugger::output($id, $name);

        $this->assertTrue(in_array($id, [
            CircuitBreaker::CLOSED,
            CircuitBreaker::OPEN,
            CircuitBreaker::HALF_OPEN,
        ]), 'Invalid id');

        $this->assertNotEmpty($name, 'no name');
    }

    /**
     * @test
     * @dataProvider providesStates
     *
     * @param State $state
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function hasDefaultCreatedAt($state)
    {
        $createdAt = $state->createdAt();

        ConsoleDebugger::output((string) $createdAt);

        $this->assertInstanceOf(DateTimeInterface::class, $createdAt, 'Incorrect created at date');
    }

    /**
     * @test
     * @dataProvider providesStates
     *
     * @param State $state
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canCreateStateThatExpires($state)
    {
        $expiresAt = Date::now()->subRealSeconds(5);

        /** @var State $state */
        $state = $state::make([ 'expires_at' => $expiresAt ]);

        $result = $state->expiresAt();
        ConsoleDebugger::output((string) $result);

        $this->assertTrue($expiresAt->eq($result), 'Expires at was not set correctly');
    }

    /**
     * @test
     * @dataProvider providesStates
     *
     * @param State $state
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canDetermineIfExpired($state)
    {
        // By default, when no expires at provided, state should
        // not be expired
        $this->assertFalse($state->hasExpired(), 'Should not be expired, when no expires at provided');

        // --------------------------------------------- //
        $expiresAt = Date::now()->subRealSeconds(5);

        /** @var State $state */
        $state = $state::make([ 'expires_at' => $expiresAt ]);

        $hasExpired = $state->hasExpired();
        ConsoleDebugger::output($hasExpired);

        $this->assertTrue($hasExpired, 'Should be expired');
    }

    /**
     * @test
     * @dataProvider providesStates
     *
     * @param State $state
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canCreateStateWithPreviousId($state)
    {
        // By default, when none provided, "previous" should be null
        $this->assertNull($state->previous(), 'Previous should be null, when no provided');

        // ---------------------------------------------- //
        $previous = $this->randomStateId();

        /** @var State $state */
        $state = $state::make([ 'previous' => $previous ]);

        $result = $state->previous();
        ConsoleDebugger::output((string) $result);

        $this->assertSame($previous, $result, 'Incorrect previous identifier specified');
    }

    /**
     * @test
     * @dataProvider providesStates
     *
     * @param State $state
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canExportToArray($state)
    {
        $data = [
            'created_at' => Date::now(),
            'expires_at' => Date::now()->addRealSeconds(22),
            'previous' => $this->randomStateId()
        ];

        /** @var State $state */
        $state = $state::make($data);

        $result = $state->toArray();
        ConsoleDebugger::output($result);

        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('created_at', $result);
        $this->assertArrayHasKey('expires_at', $result);
        $this->assertArrayHasKey('previous', $result);
    }

    /**
     * @test
     * @dataProvider providesStates
     *
     * @param State $state
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canExportToJson($state)
    {
        $data = [
            'created_at' => Date::now(),
            'expires_at' => Date::now()->addRealSeconds(1),
            'previous' => $this->randomStateId()
        ];

        /** @var State $state */
        $state = $state::make($data);

        $result = $state->toJson(JSON_PRETTY_PRINT);
        ConsoleDebugger::output($result);

        $this->assertJson($result);
    }

    /**
     * @test
     * @dataProvider providesStates
     *
     * @param State $state
     *
     * @throws JsonException
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canConvertToJson($state)
    {
        $data = [
            'created_at' => Date::now(),
            'expires_at' => Date::now()->addRealSeconds(1),
            'previous' => $this->randomStateId()
        ];

        /** @var State $state */
        $state = $state::make($data);

        $result = Json::encode($state, JSON_PRETTY_PRINT);
        ConsoleDebugger::output($result);

        $this->assertJson($result);
    }

    /**
     * @test
     * @dataProvider providesStates
     *
     * @param State $state
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canCastToString($state)
    {
        $result = (string) $state;
        ConsoleDebugger::output($result);

        $this->assertIsString($result);
    }

    /**
     * @test
     * @dataProvider providesStates
     *
     * @param State $state
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canSerializeAndUnserialize($state)
    {
        // NOTE: Dates are passed on string here on purpose, otherwise
        // we might have too much precision (milliseconds) on "now", which
        // will be lost when serialised, causing comparison to fail...
        $data = [
            'created_at' => (string) Date::now(),
            'expires_at' => (string) Date::now()->addRealSeconds(1),
            'previous' => $this->randomStateId()
        ];

        /** @var State $state */
        $state = $state::make($data);

        // ------------------------------------------- //
        $serialised = serialize($state);
        ConsoleDebugger::output($serialised);

        /** @var State $unserialized */
        $unserialized = unserialize($serialised);

        $this->assertInstanceOf(get_class($state), $unserialized);
        $this->assertTrue($unserialized->createdAt()->eq($data['created_at']), 'Incorrect created at serialisation');
        $this->assertTrue($unserialized->expiresAt()->eq($data['expires_at']), 'Incorrect expires at serialisation');
        $this->assertSame($data['previous'], $unserialized->previous(), 'Incorrect previous id serialisation');
    }
}
