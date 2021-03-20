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
    public function canRevokeSinglePermission()
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
    public function canRevokeManyPermissions()
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
    public function canRevokeSinglePermissionViaSlug()
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
    public function canRevokeManyPermissionsViaSlugs()
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
    public function canRevokeSinglePermissionViaId()
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
    public function canRevokeManyPermissionsViaIds()
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

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canRevokeAllPermissions()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $role = $this->createRole();
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Revoke all permissions and verify that no permissions are granted
        $role->revokeAllPermissions();

        $related = $role->refresh()->permissions;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount(0, $related, 'All permissions are NOT invoked');
        $this->assertFalse(
            $role->hasAnyPermissions($permissions),
            'Original permissions have not been revoked'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canDetermineIfHasAllOrAnyPermissionsGranted()
    {
        // In this test, we ensure that model is able to distinguish exactly
        // between what is granted and not - a double proof of the has, has any,
        // and has all methods.

        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $grantedPermissionA = $permissions[0];
        $grantedPermissionB = $permissions[1];
        $notGrantedPermission = $permissions[2];

        $role = $this->createRole();
        $role->grantPermissions($grantedPermissionA, $grantedPermissionB);

        // ---------------------------------------------------------------- //
        // Has - expected to be precise in that it must match ALL...

        $this->assertTrue($role->hasPermission([$grantedPermissionA, $grantedPermissionB]), 'Permissions SHOULD be matched');
        $this->assertFalse($role->hasPermission([$grantedPermissionA, $grantedPermissionB, $notGrantedPermission]), 'Permissions SHOULD NOT be matched');

        // ---------------------------------------------------------------- //
        // Has All - expected to be precise in that it must match ALL...

        $this->assertTrue($role->hasAllPermissions([$grantedPermissionA, $grantedPermissionB]), 'All permissions SHOULD be matched');
        $this->assertFalse($role->hasAllPermissions([$grantedPermissionA, $grantedPermissionB, $notGrantedPermission]), 'All permissions SHOULD NOT be matched');

        // ---------------------------------------------------------------- //
        // Has Any - expected to match any, meaning less strict than match all...

        $this->assertTrue($role->hasAnyPermissions([$grantedPermissionA, $grantedPermissionB]), 'Any permissions SHOULD be matched');
        $this->assertTrue($role->hasAnyPermissions([$grantedPermissionA, $grantedPermissionB, $notGrantedPermission]), 'Any permissions SHOULD NOT be matched');
        $this->assertFalse($role->hasAnyPermissions([$notGrantedPermission]), 'Permission is not granted, should NOT be matched');
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function doesNotRevokePermissionsWhenRoleIsSoftDeleted()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $role = $this->createRole();
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Delete role... should NOT result in roles & permissions relations
        // to be removed from the pivot table
        $role->delete();

        $table = $this->aclTable('roles_permissions');
        $this->assertDatabaseCount($table, $permissions->count(), 'testing');
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function revokesPermissionsWhenRoleIsForceDeleted()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $role = $this->createRole();
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Force delete role... Should result in pivot table not having any
        // roles & permissions relations stored.
        $role->forceDelete();

        $table = $this->aclTable('roles_permissions');
        $this->assertDatabaseCount($table, 0, 'testing');
    }
}
