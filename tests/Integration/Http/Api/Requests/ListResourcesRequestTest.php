<?php

namespace Aedart\Tests\Integration\Http\Api\Requests;

use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users\ListUsersRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\UserResource;
use Aedart\Tests\TestCases\Http\ApiResourceRequestsTestCase;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Route;
use JsonException;
use PHPUnit\Framework\Attributes\Test;

/**
 * ListResourcesRequestTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Requests
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-requests',
    'list-resources-request'
)]
class ListResourcesRequestTest extends ApiResourceRequestsTestCase
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
        Route::get('/users', function (ListUsersRequest $request) {
            return UserResource::collection(
                User::query()
                    ->paginate($request->show)
            );
        })->name('users.index');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $limit = 5;

        $url = route('users.index') . '?show=' . $limit . '&page=2';
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
        /** @var User $expected */
        $expected = User::factory()
            ->create();

        // ------------------------------------------------------------------ //

        Route::get('/users', function (ListUsersRequest $request) {
            return UserResource::collection(
                User::applyFilters($request->filters->all())
                    ->paginate($request->show)
            );
        })->name('users.index');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('users.index') . '?search=' . $expected->name . '&show=1';
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
