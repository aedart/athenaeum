<?php

namespace Aedart\Tests\Unit\Circuits\States;

use Aedart\Circuits\States\ClosedState;
use Aedart\Circuits\States\HalfOpenState;
use Aedart\Circuits\States\OpenState;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\Identifier;
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
     * @return array<string, class-string<State>[]>
     * @throws UnknownStateException
     */
    public function providesStates(): array
    {
        return [
            'closed' => [ ClosedState::class ],
            'open' => [ OpenState::class ],
            'half open' => [ HalfOpenState::class ],
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
            array_map(fn (Identifier $id) => $id->value, Identifier::cases())
        );
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @param class-string<State> $state
     * @throws UnknownStateException
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canCreateInstance(string $state): void
    {
        $state = $state::make();

        $this->assertInstanceOf(State::class, $state);
    }

    /**
     * @param class-string<State> $state
     * @throws UnknownStateException
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function hasIdentifierAndName(string $state): void
    {
        $state = $state::make();

        $id = $state->id()->value;
        $name = $state->name();

        ConsoleDebugger::output($id, $name);

        $this->assertIsInt($id, 'No ID for state');
        $this->assertNotEmpty($name, 'No name for state');
    }

    /**
     * @param class-string<State> $state
     * @throws UnknownStateException
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function hasDefaultCreatedAt(string $state): void
    {
        $state = $state::make();

        $createdAt = $state->createdAt();

        ConsoleDebugger::output((string) $createdAt);

        $this->assertInstanceOf(DateTimeInterface::class, $createdAt, 'Incorrect created at date');
    }

    /**
     * @param class-string<State> $state
     * @throws UnknownStateException
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canCreateStateThatExpires(string $state): void
    {
        $state = $state::make();

        $expiresAt = Date::now()->subRealSeconds(5);

        /** @var State $state */
        $state = $state::make([ 'expires_at' => $expiresAt ]);

        $result = $state->expiresAt();
        ConsoleDebugger::output((string) $result);

        $this->assertTrue($expiresAt->eq($result), 'Expires at was not set correctly');
    }

    /**
     * @param class-string<State> $state
     * @throws UnknownStateException
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canDetermineIfExpired(string $state): void
    {
        $state = $state::make();

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
     * @param class-string<State> $state
     * @throws UnknownStateException
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canCreateStateWithPreviousId(string $state): void
    {
        $state = $state::make();

        // By default, when none provided, "previous" should be null
        $this->assertNull($state->previous(), 'Previous should be null, when no provided');

        // ---------------------------------------------- //
        $previous = $this->randomStateId();

        /** @var State $state */
        $state = $state::make([ 'previous' => $previous ]);

        $result = $state->previous()?->value;
        ConsoleDebugger::output($result);

        $this->assertSame($previous, $result, 'Incorrect previous identifier specified');
    }

    /**
     * @param class-string<State> $state
     * @throws UnknownStateException
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canExportToArray(string $state): void
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
     * @param class-string<State> $state
     * @throws UnknownStateException
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canExportToJson(string $state): void
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
     * @param class-string<State> $state
     *
     * @throws JsonException
     * @throws UnknownStateException
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canConvertToJson(string $state): void
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
     * @param class-string<State> $state
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canCastToString(string $state): void
    {
        $result = (string) $state;
        ConsoleDebugger::output($result);

        $this->assertIsString($result);
    }

    /**
     * @param class-string<State> $state
     * @throws UnknownStateException
     */
    #[DataProvider('providesStates')]
    #[Test]
    public function canSerializeAndUnserialize(string $state): void
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
        ConsoleDebugger::output($unserialized);

        $this->assertInstanceOf($state::class, $unserialized, 'Incorrect unserialization');
        $this->assertTrue($unserialized->createdAt()->eq($data['created_at']), 'Incorrect created at serialisation');
        $this->assertTrue($unserialized->expiresAt()->eq($data['expires_at']), 'Incorrect expires at serialisation');
        $this->assertSame($data['previous'], $unserialized->previous()?->value, 'Incorrect previous id serialisation');
    }
}
