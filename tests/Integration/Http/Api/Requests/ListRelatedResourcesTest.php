<?php

namespace Aedart\Tests\Integration\Http\Api\Requests;

use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Owners\ListOwnerGamesRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\GameResource;
use Aedart\Tests\TestCases\Http\ApiResourceRequestsTestCase;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Route;
use JsonException;
use PHPUnit\Framework\Attributes\Test;

/**
 * ListRelatedResourcesTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Requests
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-requests',
    'list-related-resources-request'
)]
class ListRelatedResourcesTest extends ApiResourceRequestsTestCase
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
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function canListPaginatedResources(): void
    {
        $owner = Owner::factory()
            ->create();

        Game::factory()
            ->count(25)
            ->create([
                'owner_id' => $owner->getKey()
            ]);

        // ------------------------------------------------------------------ //

        Route::get('/owners/{id}/games', function (ListOwnerGamesRequest $request) {
            /** @var Owner $owner */
            $owner = $request->record;

            return GameResource::collection(
                $owner
                    ->games()
                    ->paginate($request->show)
            );
        })->name('owners.games');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $limit = 5;

        $url = route('owners.games', $owner->getKey()) . '?show=' . $limit . '&page=2';
        $response = $this
            ->getJson($url)
            ->assertOk();

        $content = Response::decode($response);

        // ------------------------------------------------------------------ //

        $this->assertArrayHasKey('data', $content);
        $this->assertCount($limit, $content['data']);
    }

    /**
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function canBuildAndApplyFilters(): void
    {
        $owner = Owner::factory()
            ->create();

        $games = Game::factory()
            ->count(25)
            ->create([
                'owner_id' => $owner->getKey()
            ]);

        /** @var Game $expected */
        $expected = $games
            ->random(1)
            ->first();

        // ------------------------------------------------------------------ //

        Route::get('/owners/{id}/games', function (ListOwnerGamesRequest $request) {
            /** @var Owner $owner */
            $owner = $request->record;

            return GameResource::collection(
                $owner
                    ->games()
                    ->with([ 'owner' ])
                    ->applyFilters($request->filters->all())
                    ->paginate($request->show)
            );
        })->name('owners.games');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('owners.games', $owner->getKey()) . '?search=' . $expected->slug . '&show=1';
        $response = $this
            ->getJson($url)
            ->assertOk();

        $content = Response::decode($response);

        // ------------------------------------------------------------------ //

        $this->assertArrayHasKey('data', $content);
        $this->assertCount(1, $content['data']);

        $found = $content['data'][0];
        $this->assertSame($expected->slug, $found['slug']);
    }
}
