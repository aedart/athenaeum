<?php

namespace Aedart\Tests\Integration\Http\Api\Resources;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\GameResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\OwnerResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode\All as HttpStatus;

/**
 * ResponseTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-response
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-response',
)]
class ResponseTest extends ApiResourcesTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canRespondWithCreatedStatus(): void
    {
        // ------------------------------------------------------------------ //
        // Prerequisites - we need a route to the resource, with appropriate
        // name...

        Route::get('/games/{id}', function () {
            return response()->json();
        })->name('games.show');

        // Refresh name lookup or test could fail...
        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $faker = $this->getFaker();

        $model = new Game([
            'slug' => $faker->slug(3),
            'name' => $faker->text(25),
        ]);

        $resource = new GameResource($model);

        // ------------------------------------------------------------------ //

        $request = Request::create('something');
        $response = $resource->createdResponse($request);

        ConsoleDebugger::output((string) $response);

        // ------------------------------------------------------------------ //

        $this->assertSame(HttpStatus::CREATED, $response->status(), 'Incorrect HTTP status code');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canRespondUpdated(): void
    {
        $model = new Owner([ 'name' => 'Jim' ]);

        $resource = new OwnerResource($model);

        // ------------------------------------------------------------------ //

        $request = Request::create('something');
        $response = $resource->updatedResponse($request);

        ConsoleDebugger::output((string) $response);

        // ------------------------------------------------------------------ //

        // Note: I know not of any "HTTP updated" response code... but "updatedResponse" method
        // is semantically nice to have...
        $this->assertSame(HttpStatus::OK, $response->status(), 'Incorrect HTTP status code');
    }
}
