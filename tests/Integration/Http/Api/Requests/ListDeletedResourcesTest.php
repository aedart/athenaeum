<?php

namespace Aedart\Tests\Integration\Http\Api\Requests;

use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games\ListDeletedGamesRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\GameResource;
use Aedart\Tests\TestCases\Http\ApiResourceRequestsTestCase;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;

/**
 * ListDeletedResourcesTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-requests
 * @group list-deleted-resources-request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Requests
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-requests',
    'list-deleted-resources-request'
)]
class ListDeletedResourcesTest extends ApiResourceRequestsTestCase
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
    public function canListPaginatedResources(): void
    {
        // Create a few deleted games...
        Game::factory()
            ->count(10)
            ->create([
                'deleted_at' => now()
            ]);

        Route::get('/games', function (ListDeletedGamesRequest $request) {
            return GameResource::collection(
                Game::onlyTrashed()
                    ->paginate($request->show)
            );
        })->name('games.trashed');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $limit = 5;

        $url = route('games.trashed') . '?show=' . $limit . '&page=2';
        $response = $this
            ->getJson($url)
            ->assertOk();

        $content = Response::decode($response);

        // ------------------------------------------------------------------ //

        $this->assertArrayHasKey('data', $content);
        $this->assertCount($limit, $content['data']);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function canBuildAndApplyFilters(): void
    {
        /** @var Game $expected */
        $expected = Game::factory()
            ->create([
                'deleted_at' => now()
            ]);

        // ------------------------------------------------------------------ //

        Route::get('/games', function (ListDeletedGamesRequest $request) {
            return GameResource::collection(
                Game::onlyTrashed()
                    ->applyFilters($request->filters->all())
                    ->paginate($request->show)
            );
        })->name('games.trashed');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('games.trashed') . '?search=' . $expected->slug . '&show=1';
        $response = $this
            ->getJson($url)
            ->assertOk();

        $content = Response::decode($response);

        // ------------------------------------------------------------------ //

        $this->assertArrayHasKey('data', $content);
        $this->assertCount(1, $content['data']);

        $found = $content['data'][0];
        $this->assertSame($expected->name, $found['name']);
    }
}
