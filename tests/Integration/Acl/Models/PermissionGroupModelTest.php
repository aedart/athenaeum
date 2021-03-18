<?php

namespace Aedart\Tests\Integration\Acl\Models;

use Aedart\Acl\Models\Permissions\Group;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Acl\AclTestCase;

/**
 * PermissionGroupModelTest
 *
 * @group acl
 * @group acl-models
 * @group acl-permission-group
 * @group acl-permission-group-model
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Acl\Models
 */
class PermissionGroupModelTest extends AclTestCase
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
}