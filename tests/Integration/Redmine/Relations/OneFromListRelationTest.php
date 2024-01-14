<?php

namespace Aedart\Tests\Integration\Redmine\Relations;

use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Redmine\Issue;
use Aedart\Redmine\IssueStatus;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * OneFromListRelationTest
 *
 * @group redmine
 * @group redmine-relations
 * @group redmine-relations-one-from-list
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Relations
 */
class OneFromListRelationTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws ErrorResponseException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canObtainRelatedResource()
    {
        // Debug
        //        Issue::$debug = true;

        // -------------------------------------------------------------------- //
        // Prerequisites - create a new issue

        $project = $this->createProject();
        $issue = $this->createIssue($project->id(), [
            'status_id' => 2,
            'status' => [ 'id' => 2, 'name' => 'some kind of status' ]
        ]);

        // -------------------------------------------------------------------- //
        // Obtain relation

        // Mock relation connection
        $list = [
            [
                'id' => 1,
                'name' => 'New',
                'is_closed' => false
            ],
            [
                'id' => 2,
                'name' => 'In Progress',
                'is_closed' => false
            ],
            [
                'id' => 3,
                'name' => 'Done',
                'is_closed' => true
            ],
        ];

        $relationConnection = $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, IssueStatus::class)
        ]);

        /** @var IssueStatus $status */
        $status = $issue
            ->status()
            ->usingConnection($relationConnection)
            ->fetch();

        $this->assertInstanceOf(IssueStatus::class, $status);
        $this->assertSame($issue->status->id, $status->id);

        // -------------------------------------------------------------------- //
        // Cleanup

        $issue->delete();
        $project->delete();
    }
}
