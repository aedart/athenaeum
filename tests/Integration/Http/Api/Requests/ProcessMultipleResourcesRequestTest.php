<?php

namespace Aedart\Tests\Integration\Http\Api\Requests;

use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games\DeleteMultipleGamesRequest;
use Aedart\Tests\TestCases\Http\ApiResourceRequestsTestCase;
use Codeception\Attribute\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\Fluent\AssertableJson;
use JsonException;
use PHPUnit\Framework\Attributes\Test;

/**
 * ProcessMultipleResourcesRequestTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-requests
 * @group process-multiple-resources-request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Requests
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-requests',
    'process-multiple-resources-request'
)]
class ProcessMultipleResourcesRequestTest extends ApiResourceRequestsTestCase
{
    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        // Debugging
        // $this->withoutExceptionHandling();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function canProcessMultipleResources(): void
    {
        /** @var Collection<Game> $targets */
        $targets = Game::factory()
            ->count(10)
            ->create();

        // ------------------------------------------------------------------ //

        Route::delete('/games', function (DeleteMultipleGamesRequest $request) {
            $games = $request->records;

            $slugs = $games
                ->pluck('slug')
                ->toArray();

            Game::whereSlugIn($slugs)
                ->delete();

            return response()->noContent();
        })->name('games.bulk-destroy');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('games.bulk-destroy');
        $response = $this
            ->deleteJson($url, [
                'targets' => $targets
                    ->pluck('slug')
                    ->toArray()
            ])
            ->assertNoContent();

        Response::decode($response);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function failsWhenNoTargetsRequested(): void
    {
        Route::delete('/games', function (DeleteMultipleGamesRequest $request) {
            // N/A
            return response();
        })->name('games.bulk-destroy');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('games.bulk-destroy');
        $response = $this
            ->deleteJson($url, [
                'targets' => []
            ])
            ->assertUnprocessable();

        Response::decode($response);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function failsWhenTooManyTargetsRequested(): void
    {
        /** @var Collection<Game> $targets */
        $targets = Game::factory()
            ->count(15)
            ->create();

        // ------------------------------------------------------------------ //

        Route::delete('/games', function (DeleteMultipleGamesRequest $request) {
            // N/A
            return response();
        })->name('games.bulk-destroy');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('games.bulk-destroy');
        $response = $this
            ->deleteJson($url, [
                'targets' => [
                    ...$targets
                        ->pluck('slug')
                        ->toArray(),
                ]
            ])
            ->assertUnprocessable();

        Response::decode($response);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function failsWhenNotAllTargetsFound(): void
    {
        /** @var Collection<Game> $targets */
        $targets = Game::factory()
            ->count(5)
            ->create();

        // ------------------------------------------------------------------ //

        Route::delete('/games', function (DeleteMultipleGamesRequest $request) {
            // N/A
            return response();
        })->name('games.bulk-destroy');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $unknownIdentifier = 'my-unknown-slug-identifier';

        $url = route('games.bulk-destroy');
        $response = $this
            ->deleteJson($url, [
                'targets' => [
                    ...$targets
                        ->pluck('slug')
                        ->toArray(),
                    $unknownIdentifier
                ]
            ])
            ->assertUnprocessable()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json
                    ->has(
                        'errors',
                        fn (AssertableJson $json) =>
                        $json
                            ->where('targets.5', ["{$unknownIdentifier} was not found"])
                            ->etc()
                    )
                    ->etc()
            );

        Response::decode($response);
    }
}
