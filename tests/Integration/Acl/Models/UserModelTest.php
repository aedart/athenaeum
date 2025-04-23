<?php

namespace Aedart\Tests\Integration\Acl\Models;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Acl\AclTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * UserModelTest
 *
 * @group acl
 * @group acl-models
 * @group acl-user
 * @group acl-user-model
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Acl\Models
 */
#[Group(
    'acl',
    'acl-models',
    'acl-user',
    'acl-user-model'
)]
class UserModelTest extends AclTestCase
{
    /**
     * @test
     */
    #[Test]
    public function canAssignSingleRole()
    {
        $role = $this->createRole();
        $user = $this->createUser();

        $user->assignRoles($role);

        // ---------------------------------------------------------------- //
        // Check if roles have been assigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No role have been assigned to user');
        $this->assertCount(1, $related, 'Incorrect amount of role assigned');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $user->hasAllRoles([$role]),
            'User appears NOT to have all roles assigned!'
        );
    }

    /**
     * @test
     */
    #[Test]
    public function canAssignManyRoles()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles($roles);

        // ---------------------------------------------------------------- //
        // Check if roles have been assigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No role have been assigned to user');
        $this->assertCount($roles->count(), $related, 'Incorrect amount of role assigned');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $user->hasAllRoles([$roles]),
            'User appears NOT to have all roles assigned!'
        );
    }

    /**
     * @test
     */
    #[Test]
    public function canAssignSingleRoleViaSlug()
    {
        $role = $this->createRole();
        $user = $this->createUser();

        $user->assignRoles($role->slug);

        // ---------------------------------------------------------------- //
        // Check if roles have been assigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No role have been assigned to user');
        $this->assertCount(1, $related, 'Incorrect amount of role assigned');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $user->hasAllRoles([$role->slug]),
            'User appears NOT to have all roles assigned!'
        );
    }

    /**
     * @test
     */
    #[Test]
    public function canAssignManyRolesViaSlugs()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles(
            $roles->pluck('slug')->toArray()
        );

        // ---------------------------------------------------------------- //
        // Check if roles have been assigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No role have been assigned to user');
        $this->assertCount($roles->count(), $related, 'Incorrect amount of role assigned');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $user->hasAllRoles([$roles]),
            'User appears NOT to have all roles assigned!'
        );
    }

    /**
     * @test
     */
    #[Test]
    public function canAssignSingleRoleViaId()
    {
        $role = $this->createRole();
        $user = $this->createUser();

        $user->assignRoles($role->id);

        // ---------------------------------------------------------------- //
        // Check if roles have been assigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No role have been assigned to user');
        $this->assertCount(1, $related, 'Incorrect amount of role assigned');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $user->hasAllRoles([$role->id]),
            'User appears NOT to have all roles assigned!'
        );
    }

    /**
     * @test
     */
    #[Test]
    public function canAssignManyRolesViaIds()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles(
            $roles->pluck('id')->toArray()
        );

        // ---------------------------------------------------------------- //
        // Check if roles have been assigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertNotEmpty($related->toArray(), 'No role have been assigned to user');
        $this->assertCount($roles->count(), $related, 'Incorrect amount of role assigned');

        // ---------------------------------------------------------------- //

        $this->assertTrue(
            $user->hasAllRoles([$roles]),
            'User appears NOT to have all roles assigned!'
        );
    }

    /**
     * @test
     */
    #[Test]
    public function canUnassignSingleRole()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles($roles);

        // ---------------------------------------------------------------- //
        // Unassign roles
        $roleToUnassign = $roles->last();

        $user->unassignRoles($roleToUnassign);

        // ---------------------------------------------------------------- //
        // Check if roles have been unassigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount($roles->count() - 1, $related, 'Incorrect amount of roles unassigned');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $user->hasAnyRoles([$roleToUnassign]),
            'Roles appear NOT to have been unassigned'
        );
    }

    /**
     * @test
     */
    #[Test]
    public function canUnassignManyRoles()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles($roles);

        // ---------------------------------------------------------------- //
        // Unassign roles
        $user->unassignRoles($roles);

        // ---------------------------------------------------------------- //
        // Check if roles have been unassigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount(0, $related, 'Incorrect amount of roles unassigned');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $user->hasAnyRoles([$roles]),
            'Roles appear NOT to have been unassigned'
        );
    }

    /**
     * @test
     */
    #[Test]
    public function canUnassignSingleRoleViaSlug()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles($roles);

        // ---------------------------------------------------------------- //
        // Unassign roles
        $roleToUnassign = $roles->last();

        $user->unassignRoles($roleToUnassign->slug);

        // ---------------------------------------------------------------- //
        // Check if roles have been unassigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount($roles->count() - 1, $related, 'Incorrect amount of roles unassigned');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $user->hasAnyRoles([$roleToUnassign->slug]),
            'Roles appear NOT to have been unassigned'
        );
    }

    /**
     * @test
     */
    #[Test]
    public function canUnassignManyRolesViaSlugs()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles($roles);

        // ---------------------------------------------------------------- //
        // Unassign roles
        $targets = $roles->take(2)->pluck('slug')->toArray();

        $user->unassignRoles($targets);

        // ---------------------------------------------------------------- //
        // Check if roles have been unassigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount($roles->count() - count($targets), $related, 'Incorrect amount of roles unassigned');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $user->hasAnyRoles($targets),
            'Roles appear NOT to have been unassigned'
        );
    }

    /**
     * @test
     */
    #[Test]
    public function canUnassignSingleRoleViaId()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles($roles);

        // ---------------------------------------------------------------- //
        // Unassign roles
        $roleToUnassign = $roles->last();

        $user->unassignRoles($roleToUnassign->id);

        // ---------------------------------------------------------------- //
        // Check if roles have been unassigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount($roles->count() - 1, $related, 'Incorrect amount of roles unassigned');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $user->hasAnyRoles([$roleToUnassign->id]),
            'Roles appear NOT to have been unassigned'
        );
    }

    /**
     * @test
     */
    #[Test]
    public function canUnassignManyRolesViaIds()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles($roles);

        // ---------------------------------------------------------------- //
        // Unassign roles
        $targets = $roles->take(2)->pluck('id')->toArray();

        $user->unassignRoles($targets);

        // ---------------------------------------------------------------- //
        // Check if roles have been unassigned (via relation)
        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount($roles->count() - count($targets), $related, 'Incorrect amount of roles unassigned');

        // ---------------------------------------------------------------- //

        $this->assertFalse(
            $user->hasAnyRoles($targets),
            'Roles appear NOT to have been unassigned'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    #[Test]
    public function canSyncRoles()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles($roles);

        // ---------------------------------------------------------------- //
        // Create new roles and "sync" them.
        $newRoles = $this->createRoles();

        $user->syncRoles($newRoles);

        // ---------------------------------------------------------------- //
        // Check if original roles have been removed and new ones are
        // assigned to user

        $this->assertFalse(
            $user->hasAnyRoles($roles),
            'Original roles have not been unassigned'
        );

        $this->assertTrue(
            $user->hasAllRoles($newRoles),
            'New roles have not been assigned'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    #[Test]
    public function canUnassignAllRoles()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles($roles);

        // ---------------------------------------------------------------- //
        // Unassign all roles and verify that none remain assigned to user
        $user->unassignAllRoles();

        $related = $user->refresh()->roles;

        ConsoleDebugger::output($related->toArray());

        $this->assertCount(0, $related, 'All roles are NOT unassigned');
        $this->assertFalse(
            $user->hasAnyRoles($roles),
            'Original roles have not been unassigned'
        );
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    #[Test]
    public function canDetermineIfHasAllOrAnyRolesAssigned()
    {
        // In this test, we ensure that model is able to distinguish exactly
        // between what is granted and not - a double proof of the has, has any,
        // and has all methods.

        $roles = $this->createRoles();

        $assignedRoleA = $roles[0];
        $assignedRoleB = $roles[1];
        $notAssignedRole = $roles[2];

        $user = $this->createUser();
        $user->assignRoles($assignedRoleA, $assignedRoleB);

        // ---------------------------------------------------------------- //
        // Has - expected to be precise in that it must match ALL...

        $this->assertTrue($user->hasRoles([$assignedRoleA, $assignedRoleB]), 'Roles SHOULD be matched');
        $this->assertFalse($user->hasRoles([$assignedRoleA, $assignedRoleB, $notAssignedRole]), 'Roles SHOULD NOT be matched');

        // ---------------------------------------------------------------- //
        // Has All - expected to be precise in that it must match ALL...

        $this->assertTrue($user->hasAllRoles([$assignedRoleA, $assignedRoleB]), 'All roles SHOULD be matched');
        $this->assertFalse($user->hasAllRoles([$assignedRoleA, $assignedRoleB, $notAssignedRole]), 'All roles SHOULD NOT be matched');

        // ---------------------------------------------------------------- //
        // Has Any - expected to match any, meaning less strict than match all...

        $this->assertTrue($user->hasAnyRoles([$assignedRoleA, $assignedRoleB]), 'Any roles SHOULD be matched');
        $this->assertTrue($user->hasAnyRoles([$assignedRoleA, $assignedRoleB, $notAssignedRole]), 'Any roles SHOULD NOT be matched');
        $this->assertFalse($user->hasAnyRoles([$notAssignedRole]), 'Role is not assigned, should NOT be matched');
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    #[Test]
    public function unassignsRolesWhenUserIsDeleted()
    {
        $roles = $this->createRoles();
        $user = $this->createUser();

        $user->assignRoles($roles);

        // ---------------------------------------------------------------- //
        // Delete the user... (could also be force-deleted). Pivot table
        // not have any link between given user and roles.
        $user->delete();

        $table = $this->aclTable('users_roles');
        $this->assertDatabaseCount($table, 0, 'testing');
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    #[Test]
    public function canDetermineIfPermissionIsGranted()
    {
        // Create two sets of permission groups, grant some permissions
        // to a role, ...
        $group = $this->createPermissionGroupWithPermissions('users');
        $permissions = $group->permissions;

        $grantedPermissionA = $permissions[0];
        $grantedPermissionB = $permissions[1];
        $notGrantedPermission = $permissions[2];

        $granted = [$grantedPermissionA, $grantedPermissionB];
        $notGranted = [$notGrantedPermission];

        // ---------------------------------------------------------------- //
        // Grant permissions and assign role

        $role = $this->createRole();
        $role->grantPermissions($granted);

        $user = $this->createUser();
        $user->assignRoles($role);

        // ---------------------------------------------------------------- //
        // Determine if user has specific permissions granted

        foreach ($granted as $permission) {
            $this->assertTrue($user->hasPermission($permission), 'User was expected to have permission, but does not!');
        }

        // ---------------------------------------------------------------- //
        // Ensure that user does NOT have permission to remaining

        foreach ($notGranted as $permission) {
            $this->assertFalse($user->hasPermission($permission), 'User SHOULD NOT have given permission granted');
        }
    }
}
