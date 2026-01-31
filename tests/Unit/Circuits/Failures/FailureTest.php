<?php

namespace Aedart\Tests\Unit\Circuits\Failures;

use Aedart\Circuits\Failures\CircuitBreakerFailure;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\Group;
use DateTimeInterface;
use Illuminate\Support\Facades\Date;
use PHPUnit\Framework\Attributes\Test;

/**
 * FailureTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Circuits\Failures
 */
#[Group(
    'circuits',
    'circuits-failure',
)]
class FailureTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new failure instance
     *
     * @param array $data [optional]
     *
     * @return Failure
     */
    public function makeFailure(array $data = []): Failure
    {
        return CircuitBreakerFailure::make($data);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    #[Test]
    public function canCreateInstance()
    {
        $failure = $this->makeFailure();

        $this->assertInstanceOf(Failure::class, $failure);
    }

    #[Test]
    public function canCreateWithReasonAndContext()
    {
        $faker = $this->getFaker();

        $data = [
            'reason' => $faker->sentence(),
            'context' => $faker->words(),
            'reported_at' => (string) Date::now('UTC')->subRealMinutes(5),
            'total_failures' => $faker->randomDigitNotNull()
        ];

        $failure = $this->makeFailure($data);

        $this->assertSame($data['reason'], $failure->reason(), 'Incorrect reason');
        $this->assertSame($data['context'], $failure->context(), 'Incorrect context');
        $this->assertTrue($failure->reportedAt()->eq($data['reported_at']), 'Incorrect reported at');
        $this->assertSame($data['total_failures'], $failure->totalFailures(), 'Incorrect context');
    }

    #[Test]
    public function hasReportedAtByDefault()
    {
        $failure = $this->makeFailure();

        $reportedAt = $failure->reportedAt();
        ConsoleDebugger::output((string) $reportedAt);

        $this->assertInstanceOf(DateTimeInterface::class, $reportedAt);
    }

    #[Test]
    public function canExportToArray()
    {
        $faker = $this->getFaker();

        $data = [
            'reason' => $faker->sentence(),
            'context' => $faker->words(),
            'reported_at' => (string) Date::now('UTC')->subRealMinutes(5),
            'total_failures' => $faker->randomDigitNotNull()
        ];

        $failure = $this->makeFailure($data);

        $result = $failure->toArray();
        ConsoleDebugger::output($result);

        $this->assertArrayHasKey('reason', $result);
        $this->assertArrayHasKey('context', $result);
        $this->assertArrayHasKey('reported_at', $result);
        $this->assertArrayHasKey('total_failures', $result);
    }

    #[Test]
    public function canExportToJson()
    {
        $faker = $this->getFaker();

        $data = [
            'reason' => $faker->sentence(),
            'context' => $faker->words(),
            'reported_at' => (string) Date::now('UTC')->subRealMinutes(5),
            'total_failures' => $faker->randomDigitNotNull()
        ];

        $failure = $this->makeFailure($data);

        $result = $failure->toJson(JSON_PRETTY_PRINT);
        ConsoleDebugger::output($result);

        $this->assertJson($result);
    }

    #[Test]
    public function canConvertToJson()
    {
        $faker = $this->getFaker();

        $data = [
            'reason' => $faker->sentence(),
            'context' => $faker->words(),
            'reported_at' => (string) Date::now('UTC')->subRealMinutes(5),
            'total_failures' => $faker->randomDigitNotNull()
        ];

        $failure = $this->makeFailure($data);

        $result = Json::encode($failure, JSON_PRETTY_PRINT);
        ConsoleDebugger::output($result);

        $this->assertJson($result);
    }

    #[Test]
    public function canCastToString()
    {
        $result = (string) $this->makeFailure();
        ConsoleDebugger::output($result);

        $this->assertIsString($result);
    }

    #[Test]
    public function canSerializeAndUnserialize()
    {
        $faker = $this->getFaker();

        $data = [
            'reason' => $faker->sentence(),
            'context' => $faker->words(),
            'reported_at' => (string) Date::now('UTC')->subRealMinutes(5),
            'total_failures' => $faker->randomDigitNotNull()
        ];

        $failure = $this->makeFailure($data);

        // ------------------------------------------- //
        $serialised = serialize($failure);
        ConsoleDebugger::output($serialised);

        /** @var Failure $unserialized */
        $unserialized = unserialize($serialised);

        $this->assertInstanceOf(get_class($failure), $unserialized);
        $this->assertSame($data['reason'], $failure->reason(), 'Incorrect reason');
        $this->assertSame($data['context'], $failure->context(), 'Incorrect context');
        $this->assertTrue($failure->reportedAt()->eq($data['reported_at']), 'Incorrect reported at');
        $this->assertSame($data['total_failures'], $failure->totalFailures(), 'Incorrect context');
    }
}
