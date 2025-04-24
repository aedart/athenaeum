<?php

namespace Aedart\Tests\Integration\Http\Api\Requests\Concerns;

use Aedart\Http\Api\Requests\Concerns\RecordExistence;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\TestCases\Http\ApiResourceRequestsTestCase;
use Codeception\Attribute\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;

/**
 * RecordExistenceConcernTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-request-concerns
 * @group record-existence
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Requests\Concerns
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-request-concerns',
    'record-existence'
)]
class RecordExistenceConcernTest extends ApiResourceRequestsTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a dummy class that uses concern
     *
     * @return object
     */
    public function makeConcern()
    {
        return new class() {
            use RecordExistence;
        };
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsCollectionWhenAllRecordsFound(): void
    {
        /** @var Collection<Game> $found */
        $found = Game::factory()
            ->count(5)
            ->create();

        $requested = $found
            ->pluck('slug')
            ->toArray();

        // ------------------------------------------------------------------ //

        $result = $this->makeConcern()
            ->verifyAllRecordsFound($requested, $found, 'slug');

        // ------------------------------------------------------------------ //

        $this->assertSame($found, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnAllFoundWhenNothingRequested(): void
    {
        /** @var Collection<Game> $found */
        $found = Game::factory()
            ->count(5)
            ->create();

        $requested = [];

        // ------------------------------------------------------------------ //

        $result = $this->makeConcern()
            ->verifyAllRecordsFound($requested, $found, 'slug');

        // ------------------------------------------------------------------ //

        $this->assertSame($found, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function failsWhenNotAllRecordsFound(): void
    {
        /** @var Collection<Game> $found */
        $found = Game::factory()
            ->count(5)
            ->create();

        // Identifier of an existing record
        $valid = [$found->first()->slug];

        // Several identifiers with no matching records
        $invalid = [ 'a', 'b', 'c' ];

        $requested = [
            ...$valid,
            ...$invalid,
        ];

        // ------------------------------------------------------------------ //

        $exceptionThrown = false;
        $errors = [];

        try {
            $this->makeConcern()
                ->verifyAllRecordsFound($requested, $found, 'slug');
        } catch (ValidationException $e) {
            ConsoleDebugger::output($e->errors());

            $exceptionThrown = true;
            $errors = $e->errors();
        }

        // ------------------------------------------------------------------ //

        $this->assertTrue($exceptionThrown, 'Validation exception was not thrown');
        $this->assertNotEmpty($errors, 'Error bag is empty');
        $this->assertCount(count($invalid), $errors, 'Invalid amount of errors');

        // ------------------------------------------------------------------ //

        $index = 0;
        foreach ($errors as $value) {
            $expected = "{$invalid[$index]} was not found";
            $actual = $value[0];

            $this->assertSame($expected, $actual, 'Invalid identifier marked as not found');

            $index++;
        }
    }
}
