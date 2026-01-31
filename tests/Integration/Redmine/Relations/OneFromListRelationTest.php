<?php

namespace Aedart\Tests\Integration\Redmine\Relations;

use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Redmine\Issue;
use Aedart\Redmine\IssueStatus;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * OneFromListRelationTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Relations
 */
#[Group(
    'redmine',
    'redmine-relations',
    'redmine-relations-one-from-list',
)]
class OneFromListRelationTest extends RedmineTestCase
{
    /**
     * @throws ErrorResponseException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canObtainRelatedResource()
    {
        // Debug
        // RedmineApiResource::$debug = true;

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

        // When testing locally, using a Sqlite database, the API request might be too soon after the first
        // project was deleted, which causes a "Database locked" exception / 500 Internal Server Error from
        // Redmine. To avoid this, we wait for ~250 ms.
        if ($this->isLive()) {
            usleep(250_000);
        }

        $project->delete();

        if ($this->isLive()) {
            usleep(250_000);
        }

        // Debug
        // RedmineApiResource::$debug = true;
    }
}
