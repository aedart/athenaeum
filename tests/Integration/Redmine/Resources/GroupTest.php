<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Group;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group as TestGroup;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * GroupTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-group
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
#[TestGroup(
    'redmine',
    'redmine-resources',
    'redmine-resources-group',
)]
class GroupTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canCreateRole()
    {
        // Debug
        //        Group::$debug = true;

        // ----------------------------------------------------------------------- //
        // Prerequisites - create a single user to be assigned to group

        $user = $this->createUser();

        // ----------------------------------------------------------------------- //

        $data = [
            'name' => 'Test group via @aedart/athenaeum-redmine',
            'user_ids' => [ $user->id() ]
        ];

        $created = [
            'name' => $data['name'],
            'users' => [
                [ 'id' => $user->id() ]
            ]
        ];

        $group = Group::create($data, [ 'users' ], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($created, 1324, Group::class),
            $this->mockDeletedResourceResponse()
        ]));

        // ----------------------------------------------------------------------- //

        $this->assertNotEmpty($group->id(), 'Group not created');
        $this->assertSame($data['name'], $group->name, 'Incorrect group name');

        $this->assertNotEmpty($group->users, 'No users assigned to group');
        $this->assertCount(1, $group->users, 'Incorrect amount assigned to group');
        $this->assertSame($user->id(), $group->users[0]->id, 'Incorrect user assigned to group');

        // ----------------------------------------------------------------------- //
        // Cleanup

        $group->delete();
        $user->delete();
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canUpdateGroup()
    {
        // Debug
        //        Group::$debug = true;

        // ----------------------------------------------------------------------- //
        // Prerequisites - group with a single user assigned

        $userA = $this->createUser([ 'firstname' => 'Test user A' ]);

        $data = [
            'name' => 'Test group via @aedart/athenaeum-redmine',
            'user_ids' => [ $userA->id() ]
        ];
        $created = [
            'name' => $data['name'],
            'users' => [
                [ 'id' => $userA->id() ]
            ]
        ];

        $group = Group::create($data, [ 'users' ], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($created, 1324, Group::class),
        ]));

        // ----------------------------------------------------------------------- //
        // Update group

        // CAUTION: When setting the users - Redmine will REPLACE all previous users with
        // new users list!

        $userB = $this->createUser([ 'firstname' => 'Test user B' ]);
        $changed = [
            'name' => 'Test group updated via @aedart/athenaeum-redmine',
            'user_ids' => [ $userB->id() ]
        ];
        $changedCompleted = [
            'name' => $changed['name'],
            'users' => [
                [ 'id' => $userB->id() ],
            ]
        ];

        $connection = $this->liveOrMockedConnection([
            $this->mockUpdatedResourceResponse(),
            $this->mockReloadedResourceResponse($changedCompleted, 1234, Group::class),
            $this->mockDeletedResourceResponse()
        ]);

        $result = $group
            ->setConnection($connection)
            ->withIncludes([ 'users' ])
            ->update($changed, true);

        // ----------------------------------------------------------------------- //
        // Assert changed group

        $this->assertTrue($result, 'Update failed');
        $this->assertNotEmpty($group->users, 'Users are not part of group!');

        $this->assertCount(1, $group->users);

        $expected = [ $userB->id() ]; // Expected is that list is now replaced, not merged!
        foreach ($group->users as $userReference) {
            $this->assertTrue(in_array($userReference->id, $expected), 'User id: ' . $userReference->id . ' is not expected');
        }

        // ----------------------------------------------------------------------- //
        // Cleanup

        $group->delete();
        $userB->delete();
        $userA->delete();
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canAddAndRemoveUsers()
    {
        // Debug
        //        Group::$debug = true;

        // ----------------------------------------------------------------------- //
        // Prerequisites - create empty group

        $data = [ 'name' => 'Test group via @aedart/athenaeum-redmine' ];
        $group = Group::create($data, [], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, Group::class)
        ]));

        // ----------------------------------------------------------------------- //
        // Assign x-amount of users to group

        $userA = $this->createUser([ 'firstname' => 'Test user A' ]);
        $userB = $this->createUser([ 'firstname' => 'Test user B' ]);
        $userC = $this->createUser([ 'firstname' => 'Test user C' ]);

        $reloaded = array_merge($data, [
            'users' => [
                [ 'id' => $userA->id() ],
                [ 'id' => $userB->id() ],
                [ 'id' => $userC->id() ],
            ]
        ]);

        // (Re)mock connection
        $assignConnection = $this->liveOrMockedConnection([
            $this->mockJsonResponse(),
            $this->mockJsonResponse(),
            $this->mockJsonResponse(),
            $this->mockReloadedResourceResponse($reloaded, 1234, Group::class)
        ]);
        $group->setConnection($assignConnection);

        // Add users
        $group->addUser($userA);
        $group->addUser($userB);
        $group->addUser($userC, true);

        // ----------------------------------------------------------------------- //
        // Assert users added

        $this->assertCount(3, $group->users, 'Incorrect users added');

        $expected = [
            $userA->id(),
            $userB->id(),
            $userC->id(),
        ];
        foreach ($group->users as $userReference) {
            $this->assertTrue(in_array($userReference->id, $expected), 'User id: ' . $userReference->id . ' is not expected');
        }

        // ----------------------------------------------------------------------- //
        // Remove users from group

        $unassignReloaded = array_merge($data, [
            'users' => [
                [ 'id' => $userA->id() ],
                [ 'id' => $userC->id() ],
            ]
        ]);

        // (Re)mock connection
        $assignConnection = $this->liveOrMockedConnection([
            $this->mockJsonResponse(),
            $this->mockReloadedResourceResponse($unassignReloaded, 1234, Group::class)
        ]);
        $group->setConnection($assignConnection);

        // Remove single user from group
        $group->removeUser($userB, true);

        // ----------------------------------------------------------------------- //
        // Assert users added

        $this->assertCount(2, $group->users, 'Incorrect users removed');

        $expected = [
            $userA->id(),
            $userC->id(),
        ];
        foreach ($group->users as $userReference) {
            $this->assertTrue(in_array($userReference->id, $expected), 'User id: ' . $userReference->id . ' is not expected - after remove');
        }

        // ----------------------------------------------------------------------- //
        // Cleanup

        $group->setConnection($this->liveOrMockedConnection([
            $this->mockDeletedResourceResponse()
        ]));
        $group->delete();

        $userA->delete();
        $userB->delete();
        $userC->delete();
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canListGroups()
    {
        // Debug
        //        Group::$debug = true;

        // ----------------------------------------------------------------------- //
        // Prerequisites - create a single group (for the sake if live test mode)

        $data = [
            'name' => 'Test group via @aedart/athenaeum-redmine',
        ];

        $group = Group::create($data, [], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1324, Group::class),
            $this->mockDeletedResourceResponse()
        ]));

        // ----------------------------------------------------------------------- //
        // List groups

        $limit = 3;
        $list = [
            array_merge($data, [ 'id' => 1 ]),
            [
                'id' => 2,
                'name' => 'Another group'
            ],
            [
                'id' => 3,
                'name' => 'Last group'
            ]
        ];

        $groups = Group::list($limit, 0, [], $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, Group::class, $limit)
        ]));

        // ----------------------------------------------------------------------- //
        // Assert found

        // Arrhhh... Redmine does not paginate groups... omg
        //$this->assertCount($limit, $groups->results(), 'Incorrect amount of groups returned');

        $this->assertNotEmpty($groups->results(), 'No groups found');
        foreach ($groups as $g) {
            $this->assertInstanceOf(Group::class, $g);
        }

        // ----------------------------------------------------------------------- //
        // Cleanup

        $group->delete();
    }
}
