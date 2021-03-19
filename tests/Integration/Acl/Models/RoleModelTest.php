<?php

namespace Aedart\Tests\Integration\Acl\Models;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Acl\AclTestCase;

/**
 * RoleModelTest
 *
 * @group acl
 * @group acl-models
 * @group acl-role
 * @group acl-role-model
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Acl\Models
 */
class RoleModelTest extends AclTestCase
{
    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();

        $this->installAclMigrations();
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/

    /**
     * @test
     */
    public function canCreateAndObtain()
    {
        $faker = $this->getFaker();
        $slug = $faker->slug(2);
        $name = $faker->name;
        $desc = $faker->text(20);

        $role = $this->createRole([
            'slug' => $slug,
            'name' => $name,
            'description' => $desc
        ]);

        ConsoleDebugger::output($role->toArray());

        $this->assertNotEmpty($role->id, 'Role was not created');
        $this->assertSame($slug, $role->slug);
        $this->assertSame($name, $role->name);
        $this->assertSame($desc, $role->description);
        $this->assertNotEmpty($role->created_at, 'Created at timestamp not set');
        $this->assertNotEmpty($role->updated_at, 'Updated at timestamp not set');
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantSinglePermission()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $permissionToGrant = $permissions->first();

        $role = $this->createRole();
        $role->grantPermissions($permissionToGrant);

        // ---------------------------------------------------------------- //
        // Check if permissions have been granted (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No permissions have been granted to role');
        $this->assertCount(1, $related, 'Incorrect amount of permissions granted');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $role->hasAllPermissions([$permissionToGrant]),
            'Role appears NOT to have all permissions granted!'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantManyPermissions()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;


        $role = $this->createRole();
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Check if permissions have been granted (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No permissions have been granted to role');
        $this->assertCount($permissions->count(), $related, 'Incorrect amount of permissions granted');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $role->hasAllPermissions($permissions),
            'Role appears NOT to have all permissions granted!'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantSinglePermissionViaSlug()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $permissionToGrant = $permissions->first();

        $role = $this->createRole();
        $role->grantPermissions($permissionToGrant->slug);

        // ---------------------------------------------------------------- //
        // Check if permissions have been granted (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No permissions have been granted to role');
        $this->assertCount(1, $related, 'Incorrect amount of permissions granted');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $role->hasAllPermissions([$permissionToGrant->slug]),
            'Role appears NOT to have all permissions granted!'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantManyPermissionsViaSlugs()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;


        $role = $this->createRole();
        $role->grantPermissions(
            $permissions->pluck('slug')->toArray()
        );

        // ---------------------------------------------------------------- //
        // Check if permissions have been granted (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No permissions have been granted to role');
        $this->assertCount($permissions->count(), $related, 'Incorrect amount of permissions granted');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $role->hasAllPermissions($permissions),
            'Role appears NOT to have all permissions granted!'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantSinglePermissionViaId()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $permissionToGrant = $permissions->first();

        $role = $this->createRole();
        $role->grantPermissions($permissionToGrant->id);

        // ---------------------------------------------------------------- //
        // Check if permissions have been granted (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No permissions have been granted to role');
        $this->assertCount(1, $related, 'Incorrect amount of permissions granted');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $role->hasAllPermissions([$permissionToGrant->id]),
            'Role appears NOT to have all permissions granted!'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantManyPermissionsViaIds()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;


        $role = $this->createRole();
        $role->grantPermissions(
            $permissions->pluck('id')->toArray()
        );

        // ---------------------------------------------------------------- //
        // Check if permissions have been granted (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No permissions have been granted to role');
        $this->assertCount($permissions->count(), $related, 'Incorrect amount of permissions granted');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $role->hasAllPermissions($permissions),
            'Role appears NOT to have all permissions granted!'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantRevokeSinglePermission()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $role = $this->createRole();
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Revoke permissions
        $permissionToRevoke = $permissions->last();

        $role->revokePermissions($permissionToRevoke);

        // ---------------------------------------------------------------- //
        // Check if permissions have been revoked (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount($permissions->count() - 1, $related, 'Incorrect amount of permissions revoked');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $role->hasAnyPermissions([$permissionToRevoke]),
            'Permissions appear NOT to have been revoked'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantRevokeManyPermissions()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $role = $this->createRole();
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Revoke permissions
        $role->revokePermissions($permissions);

        // ---------------------------------------------------------------- //
        // Check if permissions have been revoked (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount(0, $related, 'Incorrect amount of permissions revoked');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $role->hasAnyPermissions($permissions),
            'Permissions appear NOT to have been revoked'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantRevokeSinglePermissionViaSlug()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $role = $this->createRole();
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Revoke permissions
        $permissionToRevoke = $permissions->last();

        $role->revokePermissions($permissionToRevoke->slug);

        // ---------------------------------------------------------------- //
        // Check if permissions have been revoked (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount($permissions->count() - 1, $related, 'Incorrect amount of permissions revoked');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $role->hasAnyPermissions([$permissionToRevoke->slug]),
            'Permissions appear NOT to have been revoked'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantRevokeManyPermissionsViaSlugs()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $role = $this->createRole();
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Revoke permissions
        $targets = $permissions->take(2)->pluck('slug')->toArray();

        $role->revokePermissions($targets);

        // ---------------------------------------------------------------- //
        // Check if permissions have been revoked (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount($permissions->count() - count($targets), $related, 'Incorrect amount of permissions revoked');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $role->hasAnyPermissions($targets),
            'Permissions appear NOT to have been revoked'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantRevokeSinglePermissionViaId()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $role = $this->createRole();
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Revoke permissions
        $permissionToRevoke = $permissions->last();

        $role->revokePermissions($permissionToRevoke->id);

        // ---------------------------------------------------------------- //
        // Check if permissions have been revoked (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount($permissions->count() - 1, $related, 'Incorrect amount of permissions revoked');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $role->hasAnyPermissions([$permissionToRevoke->id]),
            'Permissions appear NOT to have been revoked'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canGrantRevokeManyPermissionsViaIds()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $role = $this->createRole();
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Revoke permissions
        $targets = $permissions->take(3)->pluck('id')->toArray();

        $role->revokePermissions($targets);

        // ---------------------------------------------------------------- //
        // Check if permissions have been revoked (via relation)
        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount($permissions->count() - count($targets), $related, 'Incorrect amount of permissions revoked');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $role->hasAnyPermissions($targets),
            'Permissions appear NOT to have been revoked'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canSyncPermissions()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $role = $this->createRole();
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Create new permissions and "sync" them.
        $newPermissions = $this->createPermissionGroupWithPermissions('other-permissions')->permissions;

        $role->syncPermissions($newPermissions);

        // ---------------------------------------------------------------- //
        // Check if original permissions have been removed and new ones are
        // granted to role

        $this->assertFalse(
            $role->hasAnyPermissions($permissions),
            'Original permissions have not been revoked'
        );

        $this->assertTrue(
            $role->hasAllPermissions($newPermissions),
            'New permissions have not been granted'
        );
    }
}