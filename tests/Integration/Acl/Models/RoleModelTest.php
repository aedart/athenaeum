<?php

namespace Aedart\Tests\Integration\Acl\Models;

use Aedart\Acl\Models\Role;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Acl\AclTestCase;
use Codeception\Attribute\Group as TestGroup;
use PHPUnit\Framework\Attributes\Test;

/**
 * RoleModelTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Acl\Models
 */
#[TestGroup(
    'acl',
    'acl-models',
    'acl-role',
    'acl-role-model'
)]
class RoleModelTest extends AclTestCase
{
    #[Test]
    public function canCreateAndObtain()
    {
        $faker = $this->getFaker();
        $slug = $faker->slug(2);
        $name = $faker->name();
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canCreateRoleWithPermissions()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions->take(3);

        $faker = $this->getFaker();
        $data = [
            'slug' => $faker->unique()->slug,
            'name' => $faker->words(3, true),
            'description' => $faker->words(20, true)
        ];

        $role = Role::createWithPermissions($data, $permissions);

        // ---------------------------------------------------------------- //
        // Ensure role was created and desired permissions have been granted

        $this->assertNotNull($role, 'Role was not created!');
        $this->assertSame($data['slug'], $role->slug, 'Incorrect attributes appear to have been used!?');

        $this->assertTrue($role->hasAllPermissions($permissions), 'Permissions do not appear to have been granted');
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canUpdateRoleWithPermissions()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions->take(2);
        $role = $this->createRole();

        $faker = $this->getFaker();
        $data = [
            'name' => $faker->words(3, true),
        ];

        $role->updateAndGrantPermissions($data, $permissions);

        // ---------------------------------------------------------------- //
        // Ensure role was updated and desired permissions have been granted

        $this->assertSame($data['name'], $role->name, 'Incorrect attributes appear to have been used!?');

        $this->assertTrue($role->hasAllPermissions($permissions), 'Permissions do not appear to have been granted');
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canUpdateRoleAndSyncPermissions()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;
        $role = $this->createRole();

        // ---------------------------------------------------------------- //
        // Initially, we grant a few permissions
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Update and sync with new Permissions

        $newPermissions = $this->createPermissionGroupWithPermissions('products')->permissions;

        $faker = $this->getFaker();
        $data = [
            'name' => $faker->words(3, true),
        ];

        $role->updateAndSyncPermissions($data, $newPermissions);

        // ---------------------------------------------------------------- //
        // Ensure role was updated and desired permissions have been granted

        $this->assertSame($data['name'], $role->name, 'Incorrect attributes appear to have been used!?');

        $this->assertTrue($role->hasAllPermissions($newPermissions), 'New permissions NOT synced');
        $this->assertFalse($role->hasAllPermissions($permissions), 'Old permissions NOT revoked');
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function revokesAllPermissionsWhenSyncUpdating()
    {
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;
        $role = $this->createRole();

        // ---------------------------------------------------------------- //
        // Initially, we grant a few permissions
        $role->grantPermissions($permissions);

        // ---------------------------------------------------------------- //
        // Update and sync with no permissions

        $faker = $this->getFaker();
        $data = [
            'name' => $faker->words(3, true),
        ];

        $role->updateAndSyncPermissions($data, []);

        // ---------------------------------------------------------------- //
        // Ensure role was updated and desired permissions have been granted

        $this->assertSame($data['name'], $role->name, 'Incorrect attributes appear to have been used!?');

        $this->assertFalse($role->hasAllPermissions($permissions), 'Old permissions NOT revoked');
    }
}
