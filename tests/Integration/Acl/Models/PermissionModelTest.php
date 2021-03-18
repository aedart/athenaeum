<?php

namespace Aedart\Tests\Integration\Acl\Models;

use Aedart\Acl\Models\Permission;
use Aedart\Acl\Models\Permissions\Group;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Acl\AclTestCase;

/**
 * PermissionModelTest
 *
 * @group acl
 * @group acl-models
 * @group acl-permission
 * @group acl-permission-model
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Acl\Models
 */
class PermissionModelTest extends AclTestCase
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
        /** @var Group $group */
        $group = Group::create([
            'slug' => 'users',
            'name' => 'User permissions group',
        ]);

        $faker = $this->getFaker();
        $slug = $faker->slug(2);
        $name = $faker->name;
        $desc = $faker->text(20);

        /** @var Permission $permission */
        $permission = Permission::create([
            'group_id' => $group->id,
            'slug' => $slug,
            'name' => $name,
            'description' => $desc
        ]);

        ConsoleDebugger::output($permission->toArray());

        $this->assertNotEmpty($permission->id, 'Permission was not created');
        $this->assertSame($group->id, $permission->group_id);
        $this->assertSame($slug, $permission->slug);
        $this->assertSame($name, $permission->name);
        $this->assertSame($desc, $permission->description);
        $this->assertNotEmpty($permission->created_at, 'Created at timestamp not set');
        $this->assertNotEmpty($permission->updated_at, 'Updated at timestamp not set');
    }

    /**
     * @test
     */
    public function canEagerLoadGroup()
    {
        /** @var Group $group */
        $group = Group::create([
            'slug' => 'users',
            'name' => 'User permissions group',
        ]);

        $faker = $this->getFaker();
        $slug = $faker->slug(2);
        $name = $faker->name;

        /** @var Permission $permission */
        Permission::create([
            'group_id' => $group->id,
            'slug' => $slug,
            'name' => $name,
        ]);

        // ------------------------------------------------------------- //

        /** @var Permission $found */
        $found = Permission::with('group')->first();

        ConsoleDebugger::output($found->toArray());

        $this->assertTrue($found->relationLoaded('group'), 'Group not eager loaded');
        $this->assertSame($group->id, $found->group->id);
    }
}