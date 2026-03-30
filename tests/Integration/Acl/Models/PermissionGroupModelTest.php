<?php

namespace Aedart\Tests\Integration\Acl\Models;

use Aedart\Acl\Models\Permission;
use Aedart\Acl\Models\Permissions\Group;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Acl\AclTestCase;
use Codeception\Attribute\Group as TestGroup;
use PHPUnit\Framework\Attributes\Test;

/**
 * PermissionGroupModelTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Acl\Models
 */
#[TestGroup(
    'acl',
    'acl-models',
    'acl-permission-group',
    'acl-permission-group-model'
)]
class PermissionGroupModelTest extends AclTestCase
{
    #[Test]
    public function canCreateAndObtain()
    {
        $faker = $this->getFaker();
        $slug = $faker->slug(2);
        $name = $faker->name();
        $desc = $faker->text(20);

        /** @var Group $group */
        $group = Group::create([
            'slug' => $slug,
            'name' => $name,
            'description' => $desc
        ]);

        ConsoleDebugger::output($group->toArray());

        $this->assertNotEmpty($group->id, 'Permission group was not created');
        $this->assertSame($slug, $group->slug);
        $this->assertSame($name, $group->name);
        $this->assertSame($desc, $group->description);
        $this->assertNotEmpty($group->created_at, 'Created at timestamp not set');
        $this->assertNotEmpty($group->updated_at, 'Updated at timestamp not set');
    }

    /**
     * @throws \Exception
     */
    #[Test]
    public function canSoftDeleteGroup()
    {
        /** @var group $group */
        $group = Group::create([
            'slug' => 'users',
            'name' => 'Users',
        ]);

        $result = $group->delete();

        $this->assertTrue($result, 'Group was not deleted');
        $this->assertTrue($group->trashed(), 'Group is not soft-deleted (not trashed)');
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canCreateWithPermissions()
    {
        $permissions = $this->makePermissionsForGroupCreate();

        /** @var Group $group */
        $group = Group::createWithPermissions('users', $permissions);

        // Reload with permissions
        $group = $group::with('permissions')->first();

        ConsoleDebugger::output($group->toArray());

        $this->assertCount(count($permissions), $group->permissions, 'Incorrect amount of permissions created');
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function deletesPermissionsWhenGroupForcedDeleted()
    {
        $table = (new Permission())->getTable();
        $permissions = $this->makePermissionsForGroupCreate();

        /** @var Group $group */
        $group = Group::createWithPermissions('users', $permissions);

        // Control test
        $this->assertDatabaseCount($table, count($permissions), 'testing');

        // Force delete
        $result = $group->forceDelete();

        $this->assertTrue($result, 'Group was not force deleted');
        $this->assertDatabaseCount($table, 0, 'testing');
    }
}
