<?php

namespace Aedart\Tests\Integration\Redmine\Relations\Custom;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Group;
use Aedart\Redmine\User;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use JsonException;
use Throwable;

/**
 * AssignedToRelationTest
 *
 * @group redmine
 * @group redmine-relations
 * @group redmine-relations-assigned-to
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Relations\Custom
 */
class AssignedToRelationTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    public function returnsGroupWhenAssigned()
    {
        // Debug
        //        Group::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites - a new project with a members

        $project = $this->createProject();
        $group = $this->createGroup();
        $role = $this->randomRole();
        $member = $this->createProjectGroupMember($project, $group, [ $role ]);

        // -------------------------------------------------------- //
        // Create new issue, assign a group to it.

        $issue = $this->createIssue($project->id(), [
            // This feels really hacky... no documentation about this being possible
            'assigned_to_id' => $group->id()
        ]);
        $issue->fill([ 'assigned_to' => [ 'id' => $group->id(), 'name' => $group->name ] ]); // Mock relation

        // -------------------------------------------------------- //
        // Assert relation

        // (Re)mock connection, so that we can obtain a group
        $relatedConnection = $this->liveOrMockedConnection([
            $this->mockSingleResourceResponse($group->toArray(), $group->id(), Group::class)
        ]);

        $assigned = $issue
            ->assignedTo()
            ->usingConnection($relatedConnection)
            ->fetch();

        $this->assertInstanceOf(Group::class, $assigned, 'Incorrect assigned to type returned');
        $this->assertSame($group->id(), $assigned->id(), 'Incorrect group id returned');
        $this->assertSame($group->name, $assigned->name, 'Incorrect group name returned');

        // -------------------------------------------------------- //
        // Cleanup

        $issue->delete();
        $member->delete();
        $group->delete();
        $project->delete();
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    public function returnsUserWhenAssigned()
    {
        // Debug
        //        User::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites - a new project with a members

        $project = $this->createProject();
        $user = $this->createUser();
        $role = $this->randomRole();
        $member = $this->createProjectUserMember($project, $user, [ $role ]);

        // -------------------------------------------------------- //
        // Create new issue, assign a user to it.

        $issue = $this->createIssue($project->id(), [
            'assigned_to_id' => $user->id()
        ]);
        $issue->fill([ 'assigned_to' => [ 'id' => $user->id() ] ]); // Mock relation

        // -------------------------------------------------------- //
        // Assert relation

        // (Re)mock connection, so that we can obtain a group
        $relatedConnection = $this->liveOrMockedConnection([
            $this->mockNotFoundResponse(),
            $this->mockSingleResourceResponse($user->toArray(), $user->id(), User::class)
        ]);

        $assigned = $issue
            ->assignedTo()
            ->usingConnection($relatedConnection)
            ->fetch();

        $this->assertInstanceOf(User::class, $assigned, 'Incorrect assigned to type returned');
        $this->assertSame($user->id(), $assigned->id(), 'Incorrect user id returned');

        // -------------------------------------------------------- //
        // Cleanup

        $issue->delete();
        $member->delete();
        $user->delete();
        $project->delete();
    }
}
