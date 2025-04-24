<?php

namespace Aedart\Tests\Integration\Http\Api\Requests;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games\DeleteGameRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\GameResource;
use Aedart\Tests\TestCases\Http\ApiResourceRequestsTestCase;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Route;
use JsonException;
use PHPUnit\Framework\Attributes\Test;

/**
 * DeleteSingleResourceRequestTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-requests
 * @group delete-single-resource-request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Requests
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-requests',
    'delete-single-resource-request'
)]
class DeleteSingleResourceRequestTest extends ApiResourceRequestsTestCase
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
    public function canDeleteResource(): void
    {
        /** @var Game $expected */
        $expected = Game::factory()
            ->create();

        // ------------------------------------------------------------------ //

        Route::delete('/games/{slug}', function (DeleteGameRequest $request) {
            $game = $request->record;
            $game->delete();

            return GameResource::make($game);
        })->name('games.destroy');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('games.destroy', $expected->getSlugKey());
        $response = $this
            ->deleteJson($url)
            ->assertOk();

        $content = Response::decode($response);

        // ------------------------------------------------------------------ //

        $this->assertArrayHasKey('data', $content);

        $data = $content['data'];
        $this->assertArrayHasKey('deleted', $data);

        $this->assertTrue($data['deleted']);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException|ETagGeneratorException
     */
    #[Test]
    public function evaluatesRequestPrecondition(): void
    {
        /** @var Game $expected */
        $expected = Game::factory()
            ->create();

        // ------------------------------------------------------------------ //

        Route::delete('/games/{slug}', function (DeleteGameRequest $request) {
            $game = $request->record;
            $game->delete();

            return GameResource::make($game);
        })->name('games.destroy');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //
        // If-Match

        $url = route('games.destroy', $expected->getSlugKey());
        $responseA = $this
            ->deleteJson($url, [], [
                'If-Match' => $expected->getStrongEtag()->toString()
            ])
            ->assertOk();

        Response::decode($responseA);

        // ------------------------------------------------------------------ //
        // If-Unmodified-Since

        $responseB = $this
            ->deleteJson($url, [], [
                'If-Unmodified-Since' => $expected->updated_at->subSeconds(1)->toRfc7231String()
            ])

            // Here the resource is already deleted, so it should just return 2xx, instead of
            // 412 Precondition Failed
            ->assertNoContent();

        Response::decode($responseB);
    }
}
