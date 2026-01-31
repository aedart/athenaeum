<?php

namespace Aedart\Tests\Integration\Http\Api\Requests;

use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users\CreateUserRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\UserResource;
use Aedart\Tests\TestCases\Http\ApiResourceRequestsTestCase;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Route;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode\All as HttpStatus;

/**
 * CreateSingleResourceRequestTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Requests
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-requests',
    'create-single-resource-request'
)]
class CreateSingleResourceRequestTest extends ApiResourceRequestsTestCase
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
    public function canCreateSingleResource(): void
    {
        /** @var User $expected */
        $expected = User::factory()
            ->make();

        // ------------------------------------------------------------------ //

        Route::post('/users', function (CreateUserRequest $request) {
            $name = $request->validated('name');
            $user = User::create([
                'name' => $name
            ]);

            return UserResource::make($user)
                ->createdResponse();
        })->name('users.store');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('users.store');
        $response = $this
            ->postJson($url, [
                'name' => $expected->name
            ])
            ->assertCreated();

        $content = Response::decode($response);

        // ------------------------------------------------------------------ //

        $this->assertArrayHasKey('data', $content);

        $data = $content['data'];
        $this->assertArrayHasKey('name', $data);

        $this->assertSame($expected->name, $data['name']);
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
            ->make();

        // ------------------------------------------------------------------ //

        Route::post('/users', function (CreateUserRequest $request) {
            $name = $request->validated('name');
            $user = User::create([
                'name' => $name
            ]);

            return UserResource::make($user)
                ->createdResponse();
        })->name('users.store');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('users.store');
        $responseA = $this
            ->postJson($url, [
                'name' => $expected->name
            ])
            ->assertCreated();

        Response::decode($responseA);

        // ------------------------------------------------------------------ //
        // If-Unmodified-Since

        $responseB = $this
            ->postJson($url, [ 'name' => $expected->name], [
                // [...] If ... last modification date is earlier than or equal to the date
                // provided in the field value, the condition is true [...]
                //
                // Attempt to provoke a "412 Precondition Failed" error, by setting unmodified
                // date much earlier than "now"!
                'If-Unmodified-Since' => now()->subMinutes(20)->toRfc7231String()
            ])
            ->assertStatus(HttpStatus::PRECONDITION_FAILED);

        Response::decode($responseB);
    }
}
