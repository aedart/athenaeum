<?php

namespace Aedart\Tests\Integration\Http\Api\Requests;

use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users\ShowUserRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\UserResource;
use Aedart\Tests\TestCases\Http\ApiResourceRequestsTestCase;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Route;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode\All as HttpStatus;

/**
 * ShowResourceRequestTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Requests
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-requests',
    'show-single-resource-request'
)]
class ShowSingleResourceRequestTest extends ApiResourceRequestsTestCase
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
    public function canShowResource(): void
    {
        $expected = User::factory()
            ->create();

        // ------------------------------------------------------------------ //

        Route::get('/users/{id}', function (ShowUserRequest $request) {
            return UserResource::make($request->record);
        })->name('users.show');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('users.show', $expected->getKey());
        $response = $this
            ->getJson($url)
            ->assertOk();

        $content = Response::decode($response);

        // ------------------------------------------------------------------ //

        $this->assertArrayHasKey('data', $content);

        $data = $content['data'];
        $this->assertArrayHasKey('id', $data);

        $this->assertSame($expected->getKey(), $data['id']);
    }

    /**
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function evaluatesRequestPrecondition(): void
    {
        /** @var User $expected */
        $expected = User::factory()
            ->create();

        // ------------------------------------------------------------------ //

        Route::get('/users/{id}', function (ShowUserRequest $request) {
            return UserResource::make($request->record)
                ->withCache();
        })->name('users.show');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('users.show', $expected->getKey());
        $responseA = $this
            ->getJson($url)
            ->assertOk();

        Response::decode($responseA);

        // ------------------------------------------------------------------ //
        // If-None-Match

        $headersA = $responseA->headers;
        $responseB = $this
            ->getJson($url, [
                'If-None-Match' => $headersA->get('etag')
            ])
            ->assertStatus(HttpStatus::NOT_MODIFIED);

        Response::decode($responseB);

        // ------------------------------------------------------------------ //
        // If-Modified-Since

        $responseC = $this
            ->getJson($url, [
                'If-Modified-Since' => $headersA->get('last-modified')
            ])
            ->assertStatus(HttpStatus::NOT_MODIFIED);

        Response::decode($responseC);
    }
}
