<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\ProjectMembership;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * ProjectMembershipTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-membership
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class ProjectMembershipTest extends RedmineTestCase
{
    /*****************************************************************
     * Actual Test
     ****************************************************************/

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canCreateUserMembership()
    {
        // Debug
        //        ProjectMembership::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites

        $project = $this->createProject();
        $user = $this->createUser();
        $role = $this->randomRole();

        // -------------------------------------------------------- //
        // Create membership

        $data = [
            'project' => [ 'id' => $project->id, 'name' => $project->name ],
            'user' => [ 'id' => $user->id() ],
            'roles' => [
                ['id' => $role->id(), 'name' => $role->name]
            ]
        ];

        // (Re)Mock connection on project, to return new membership response.
        // Connection is passed on to related resource...
        $originalConnection = $project->getConnection();
        $project->setConnection($this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, ProjectMembership::class),
            $this->mockDeletedResourceResponse()
        ]));

        // Create membership via the project's helper method!
        $member = $project->addUserMember($user, [ $role->id() ]);

        // -------------------------------------------------------- //
        // Assert created membership

        $this->assertSame($project->id(), $member->project->id, 'Incorrect project relation');
        $this->assertSame($user->id(), $member->user->id, 'Incorrect user');
        $this->assertSame($role->id(), $member->roles[0]->id, 'Incorrect role');

        // -------------------------------------------------------- //
        // Cleanup

        $member->delete();
        $user->delete();

        $project->setConnection($originalConnection);

        // When testing locally, using a Sqlite database, the API request might be too soon after the first
        // project was deleted, which causes a "Database locked" exception / 500 Internal Server Error from
        // Redmine. To avoid this, we wait for ~250 ms.
        if ($this->isLive()) {
            usleep(250_000);
        }

        $project->delete();

        if ($this->isLive()) {
            usleep(150_000);
        }
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canCreateGroupMember()
    {
        // Debug
        //        ProjectMembership::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites

        $project = $this->createProject();
        $group = $this->createGroup();
        $role = $this->randomRole();

        // -------------------------------------------------------- //
        // Create membership

        $data = [
            'project' => [ 'id' => $project->id, 'name' => $project->name ],
            'group' => [ 'id' => $group->id() ],
            'roles' => [
                ['id' => $role->id(), 'name' => $role->name]
            ]
        ];

        // (Re)Mock connection on project, to return new membership response.
        // Connection is passed on to related resource...
        $originalConnection = $project->getConnection();
        $project->setConnection($this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, ProjectMembership::class),
            $this->mockDeletedResourceResponse()
        ]));

        // Create membership via the project's helper method!
        $member = $project->addGroupMember($group, [ $role->id() ]);

        // -------------------------------------------------------- //
        // Assert created membership

        $this->assertSame($project->id(), $member->project->id, 'Incorrect project relation');
        $this->assertSame($group->id(), $member->group->id, 'Incorrect group');
        $this->assertSame($role->id(), $member->roles[0]->id, 'Incorrect role');

        // -------------------------------------------------------- //
        // Cleanup

        $member->delete();
        $group->delete();

        $project->setConnection($originalConnection);

        // When testing locally, using a Sqlite database, the API request might be too soon after the first
        // project was deleted, which causes a "Database locked" exception / 500 Internal Server Error from
        // Redmine. To avoid this, we wait for ~250 ms.
        if ($this->isLive()) {
            usleep(250_000);
        }

        $project->delete();

        if ($this->isLive()) {
            usleep(150_000);
        }
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canUpdateMember()
    {
        // Debug
        //        ProjectMembership::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites - create new member for project

        $project = $this->createProject();
        $user = $this->createUser();
        $role = $this->randomRole();

        $member = $this->createProjectUserMember($project, $user, [ $role ]);

        // -------------------------------------------------------- //
        // Update member

        $newRole = $this->randomRole();
        $changed = [
            'user_id' => $user->id,
            'role_ids' => [ $newRole->id ]
        ];
        $reloaded = [
            'project' => [ 'id' => $project->id, 'name' => $project->name ],
            'user' => [ 'id' => $user->id() ],
            'roles' => [
                [ 'id' => $newRole->id, 'name' => $newRole->name ]
            ]
        ];

        $connection = $this->liveOrMockedConnection([
            $this->mockUpdatedResourceResponse(),
            $this->mockReloadedResourceResponse($reloaded, 1234, ProjectMembership::class),
            $this->mockDeletedResourceResponse()
        ]);

        $result = $member
            ->setConnection($connection)
            ->update($changed, true);

        // -------------------------------------------------------- //
        // Assert was updated

        $this->assertTrue($result, 'Member was not updated');
        $this->assertSame($newRole->id, $member->roles[0]->id, 'Member role(s) not updated');

        // -------------------------------------------------------- //
        // Cleanup

        $member->delete();
        $user->delete();

        // When testing locally, using a Sqlite database, the API request might be too soon after the first
        // project was deleted, which causes a "Database locked" exception / 500 Internal Server Error from
        // Redmine. To avoid this, we wait for ~250 ms.
        if ($this->isLive()) {
            usleep(250_000);
        }

        $project->delete();

        if ($this->isLive()) {
            usleep(150_000);
        }
    }

    /**
     * @test
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canFetchMembersForProject()
    {
        // Debug
        //        ProjectMembership::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites - create a few versions for a project

        $project = $this->createProject();
        $userA = $this->createUser();
        $userB = $this->createUser();
        $group = $this->createGroup();
        $role = $this->randomRole();

        $memberA = $this->createProjectUserMember($project, $userA, [ $role ]);
        $memberB = $this->createProjectUserMember($project, $userB, [ $role ]);
        $memberC = $this->createProjectGroupMember($project, $group, [ $role ]);

        // -------------------------------------------------------- //
        // List memberships for project

        $limit = 3;
        $list = [
            $memberA->toArray(),
            $memberB->toArray(),
            $memberC->toArray(),
        ];

        $relationConnection = $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, ProjectMembership::class, 100, $limit)
        ]);

        // Fetch project's versions via custom relation
        $versions = $project
            ->members()
            ->usingConnection($relationConnection)
            ->limit($limit)
            ->fetch();

        // -------------------------------------------------------- //
        // Assert found relation

        $this->assertNotEmpty($versions->results(), 'No results obtained');
        $this->assertSame($limit, $versions->limit(), 'Incorrect limit');

        foreach ($versions as $version) {
            $this->assertInstanceOf(ProjectMembership::class, $version);
        }

        // -------------------------------------------------------- //
        // Cleanup

        $memberA->delete();
        $memberB->delete();
        $memberC->delete();

        $userA->delete();
        $userB->delete();
        $group->delete();

        // When testing locally, using a Sqlite database, the API request might be too soon after the first
        // project was deleted, which causes a "Database locked" exception / 500 Internal Server Error from
        // Redmine. To avoid this, we wait for ~250 ms.
        if ($this->isLive()) {
            usleep(250_000);
        }

        $project->delete();

        if ($this->isLive()) {
            usleep(150_000);
        }
    }
}
