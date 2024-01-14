<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Role;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * RoleTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-role
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class RoleTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canListRoles()
    {
        // Debug
        //        Role::$debug = true;

        // ---------------------------------------------------------- //
        // List roles

        $list = [
            [
                'id' => 1,
                'name' => 'manager',
            ],
            [
                'id' => 2,
                'name' => 'developer',
            ],
            [
                'id' => 3,
                'name' => 'reporter',
            ],
        ];

        $roles = Role::list(10, 0, [], $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, Role::class)
        ]));

        // ---------------------------------------------------------- //
        // Assert found

        $this->assertNotEmpty($roles->results(), 'No roles returned');
        foreach ($roles as $role) {
            $this->assertInstanceOf(Role::class, $role);
        }
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws ErrorResponseException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canFetchSingleRole()
    {
        // Debug
        //        Role::$debug = true;

        // ---------------------------------------------------------- //
        // Prerequisites - fetch random role

        // Select a random target
        $target = $this->randomRole();

        // ---------------------------------------------------------- //
        // Fetch single role (which should contain more information than the list)

        $data = array_merge($target->toArray(), [
            'assignable' => true,
            'issues_visibility' => 'all',
            'time_entries_visibility' => 'all',
            'users_visibility' => 'all',
            'permissions' => [
                'add_project',
                'edit_project',
                'close_project'
            ]
        ]);

        $role = Role::findOrFail($target->id(), [], $this->liveOrMockedConnection([
            $this->mockSingleResourceResponse($data, $target->id(), Role::class)
        ]));

        // ---------------------------------------------------------- //
        // Assert found

        $this->assertNotEmpty($role->permissions, 'No permissions obtained for single role');
    }
}
