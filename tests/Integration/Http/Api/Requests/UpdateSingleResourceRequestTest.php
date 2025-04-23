<?php

namespace Aedart\Tests\Integration\Http\Api\Requests;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users\UpdateUserRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\UserResource;
use Aedart\Tests\TestCases\Http\ApiResourceRequestsTestCase;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Route;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode\All as HttpStatus;

/**
 * UpdateSingleResourceRequestTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-requests
 * @group update-single-resource-request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Requests
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-requests',
    'update-single-resource-request'
)]
class UpdateSingleResourceRequestTest extends ApiResourceRequestsTestCase
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
    public function canCreateSingleResource(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var User $changed */
        $changed = User::factory()
            ->make();

        // ------------------------------------------------------------------ //

        Route::patch('/users/{id}', function (UpdateUserRequest $request) {
            $user = $request->record;
            $user->name = $request->validated('name');
            $user->save();

            return UserResource::make($user);
        })->name('users.update');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('users.update', $user->getKey());
        $response = $this
            ->patchJson($url, [
                'name' => $changed->name
            ])
            ->assertOk();

        $content = Response::decode($response);

        // ------------------------------------------------------------------ //

        $this->assertArrayHasKey('data', $content);

        $data = $content['data'];
        $this->assertArrayHasKey('name', $data);

        $this->assertSame($changed->name, $data['name']);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     * @throws ETagGeneratorException
     */
    #[Test]
    public function evaluatesRequestPrecondition(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->create();

        /** @var User $changed */
        $changed = User::factory()
            ->make();

        // ------------------------------------------------------------------ //

        Route::patch('/users/{id}', function (UpdateUserRequest $request) {
            $user = $request->record;
            $user->name = $request->validated('name');
            $user->save();

            return UserResource::make($user)
                ->withCache();
        })->name('users.update');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //
        // If-Match

        $url = route('users.update', $user->getKey());
        $responseA = $this
            ->patchJson($url, [ 'name' => $changed->name ], [
                'If-Match' => $user->getStrongEtag()->toString()
            ])
            ->assertOk();

        Response::decode($responseA);

        // ------------------------------------------------------------------ //
        // If-Unmodified-Since

        $responseB = $this
            ->patchJson($url, [ 'name' => $changed->name ], [
                'If-Unmodified-Since' => $user->updated_at->subSeconds(1)->toRfc7231String()
            ])
            ->assertStatus(HttpStatus::PRECONDITION_FAILED);

        Response::decode($responseB);
    }
}
