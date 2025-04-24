<?php

namespace Aedart\Tests\Integration\Http\Api\Middleware;

use Aedart\Http\Api\Middleware\RemoveResponsePayload;
use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode\All as Status;

/**
 * RemoveResponsePayloadMiddlewareTest
 *
 * @group http-api
 * @group http-api-middleware
 * @group http-api-middleware-remove-payload
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Middleware
 */
#[Group(
    'http-api',
    'http-api-middleware',
    'http-api-middleware-remove-payload'
)]
class RemoveResponsePayloadMiddlewareTest extends ApiResourcesTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function convertsResponseToNoContent(): void
    {
        $key = 'nrp';
        Route::patch('/games/{id}', function (Request $request) {
            return response()->json([
                'name' => $request->get('name', 'N/A')
            ]);
        })
            ->name('games.show')
            ->middleware([
                RemoveResponsePayload::class . ':' . $key
            ]);

        // Refresh name lookup or test could fail...
        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('games.show', 42) . '?' . $key . '=1';
        $response = $this
            ->patchJson($url, [
                'name' => 'Sine Gordon'
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
    public function doesNotConvertWhenResponseIsNotSuccessful(): void
    {
        $key = 'nrp';
        Route::patch('/games/{id}', function (Request $request) {
            return response()->json([
                'error' => 'some error'
            ], Status::UNPROCESSABLE_ENTITY);
        })
            ->name('games.show')
            ->middleware([
                RemoveResponsePayload::class . ':' . $key
            ]);

        // Refresh name lookup or test could fail...
        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('games.show', 42) . '?' . $key . '=1';
        $response = $this
            ->patchJson($url, [
                'name' => 'Sine Gordon'
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
    public function keepsOriginalHeaders(): void
    {
        $key = 'nrp';
        Route::patch('/games/{id}', function (Request $request) {
            return response()->json([
                'name' => $request->get('name', 'N/A')
            ], Status::OK, [
                'X-Custom' => 'Sweet'
            ]);
        })
            ->name('games.show')
            ->middleware([
                RemoveResponsePayload::class . ':' . $key
            ]);

        // Refresh name lookup or test could fail...
        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('games.show', 42) . '?' . $key . '=1';
        $response = $this
            ->patchJson($url, [
                'name' => 'Sine Gordon'
            ])
            ->assertNoContent();

        Response::decode($response);

        // ------------------------------------------------------------------ //

        $headers = $response->headers;
        $this->assertTrue($headers->has('x-custom'));
        $this->assertSame('Sweet', $headers->get('x-custom'));
    }
}
