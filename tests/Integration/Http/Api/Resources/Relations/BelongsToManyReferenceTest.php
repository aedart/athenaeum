<?php

namespace Aedart\Tests\Integration\Http\Api\Resources\Relations;

use Aedart\Http\Api\Resources\ApiResource;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Role;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\RoleResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\UserResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;

/**
 * BelongsToManyReferenceTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources\Relations
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-relations',
    'api-resource-relations-references',
    'api-resource-relation-belongs-to-many',
)]
class BelongsToManyReferenceTest extends ApiResourcesTestCase
{
    /**
     * When true, migrations for this test-case will
     * be installed.
     *
     * @var bool
     */
    protected bool $installMigrations = true;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        // Create a few dummy records in the database...
        User::factory()
            ->has(Role::factory()->count(2))
            ->count(3)
            ->create();

        // Register Owner Resource
        $this->getApiResourceRegistrar()->register([
            User::class => UserResource::class,
            Role::class => RoleResource::class,
        ]);

        // ------------------------------------------------------------------ //
        // Prerequisites - we need a route to the resource, with appropriate
        // name...

        Route::get('/users/{id}', function () {
            return response()->json();
        })->name('users.show');

        Route::get('/roles/{id}', function () {
            return response()->json();
        })->name('roles.show');

        // Refresh name lookup or test could fail...
        Route::getRoutes()->refreshNameLookups();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     */
    #[Test]
    public function canFormatBelongsToManyReference(): void
    {
        /** @var User $record */
        $record = User::query()
            ->with([ 'roles' ])
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new UserResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                // Manually add relation
                $payload['roles'] = $resource
                    ->belongsToManyReference('roles')
                    ->withLabel('name')
                    ->withSelfLink()
                    ->withResourceType();

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('roles', $result);

        $rolesCollection = $record->roles;
        $roles = $result['roles'];

        $this->assertCount($record->roles->count(), $roles, 'Invalid amount of related models loaded');

        foreach ($roles as $index => $owner) {
            $this->assertArrayHasKey('id', $owner);
            $this->assertSame($rolesCollection[$index]->getKey(), $owner['id']);

            $this->assertArrayHasKey('name', $owner);
            $this->assertSame($rolesCollection[$index]->name, $owner['name']);

            $this->assertArrayHasKey('type', $owner);
            $this->assertSame('role', $owner['type']);

            $this->assertArrayHasKey('self', $owner);
            $this->assertNotEmpty($owner['self']);
        }
    }

    /**
     * @return void
     */
    #[Test]
    public function canFormatBelongsToManyReferenceFromInverseModel(): void
    {
        /** @var Role $record */
        $record = Role::factory()
            ->has(User::factory()->count(4))
            ->create();

        $record->loadMissing(['users']);

        // -------------------------------------------------------------- //

        $resource = (new RoleResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                // Manually add relation
                $payload['users'] = $resource
                    ->belongsToManyReference('users')
                    ->withLabel('name')
                    ->withSelfLink()
                    ->withResourceType();

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('users', $result);

        $usersCollection = $record->users;
        $users = $result['users'];

        $this->assertCount($record->users->count(), $users, 'Invalid amount of related models loaded');

        foreach ($users as $index => $owner) {
            $this->assertArrayHasKey('id', $owner);
            $this->assertSame($usersCollection[$index]->getKey(), $owner['id']);

            $this->assertArrayHasKey('name', $owner);
            $this->assertSame($usersCollection[$index]->name, $owner['name']);

            $this->assertArrayHasKey('type', $owner);
            $this->assertSame('user', $owner['type']);

            $this->assertArrayHasKey('self', $owner);
            $this->assertNotEmpty($owner['self']);
        }
    }

    /**
     * @return void
     */
    #[Test]
    public function returnsNullWhenNotRelationNotEagerLoaded(): void
    {
        /** @var User $record */
        $record = User::query()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new UserResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                // Manually add relation
                $payload['roles'] = $resource
                    ->belongsToManyReference('roles');

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('roles', $result);
        $this->assertNull($result['roles']);
    }

    /**
     * @return void
     */
    #[Test]
    public function returnsEmptyArrayWhenNoRelatedModelsExist(): void
    {
        /** @var User $record */
        $record = User::factory()
            ->create();

        $record->loadMissing([ 'roles' ]);

        // -------------------------------------------------------------- //

        $resource = (new UserResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                // Manually add relation
                $payload['roles'] = $resource
                    ->belongsToManyReference('roles');

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('roles', $result);
        $this->assertIsArray($result['roles']);
        $this->assertEmpty($result['roles']);
    }
}
