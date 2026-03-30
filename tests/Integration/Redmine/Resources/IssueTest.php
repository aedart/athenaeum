<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Issue;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * IssueTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-issue',
)]
class IssueTest extends RedmineTestCase
{
    /**
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canCreateIssue()
    {
        // Debug
        //        Issue::$debug = true;

        // ----------------------------------------------------------------------- //
        // Prerequisites
        $project = $this->createProject();

        // ----------------------------------------------------------------------- //

        $data = [
            'project_id' => $project->id(),
            'status_id' => 1,
            'tracker_id' => 1,
            'subject' => 'Issue via @aedart/athenaeum-redmine',
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];

        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, Issue::class),
            $this->mockDeletedResourceResponse(),
        ]);

        // ----------------------------------------------------------------------- //

        $issue = Issue::create($data, [], $connection);

        $this->assertNotEmpty($issue->id(), 'Issue was not created');

        // ----------------------------------------------------------------------- //
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
            usleep(150_000);
        }
    }

    /**
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canUpdateIssue()
    {
        // Debug
        //        Issue::$debug = true;

        // ----------------------------------------------------------------------- //
        // Prerequisites
        $project = $this->createProject();

        // ----------------------------------------------------------------------- //

        $data = [
            'project_id' => $project->id(),
            'status_id' => 1,
            'tracker_id' => 1,
            'subject' => 'Issue via @aedart/athenaeum-redmine',
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];

        $changed = array_merge($data, [
            'subject' => 'Issue updated via @aedart/athenaeum-redmine'
        ]);

        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, Issue::class),
            $this->mockUpdatedResourceResponse(),
            $this->mockReloadedResourceResponse($changed, 1234, Issue::class),
            $this->mockDeletedResourceResponse(),
        ]);

        // ----------------------------------------------------------------------- //
        // More prerequisites

        $issue = Issue::create($data, [], $connection);

        $this->assertNotEmpty($issue->id(), 'Issue was not created');

        // ----------------------------------------------------------------------- //
        // Update

        $result = $issue->update($changed, true);

        $this->assertTrue($result, 'Issue was not updated');
        $this->assertSame($changed['subject'], $issue->subject, 'Issue subject was not changed');

        // ----------------------------------------------------------------------- //
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
            usleep(150_000);
        }
    }

    /**
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canListIssues()
    {
        // Debug
        // RedmineApiResource::$debug = true;

        // ----------------------------------------------------------------------- //
        // Prerequisites
        $project = $this->createProject();

        // ----------------------------------------------------------------------- //

        $id = 1234;
        $data = [
            'project_id' => $project->id(),
            'status_id' => 1,
            'tracker_id' => 1,
            'subject' => 'Issue via @aedart/athenaeum-redmine',
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];

        $list = [
            array_merge($data, [ 'id' => $id ]),
            [
                'id' => 6666,
                'project_id' => $project->id(),
                'status_id' => 1,
                'tracker_id' => 1,
                'subject' => 'Another Issue via @aedart/athenaeum-redmine',
                'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
            ],
            [
                'id' => 5555,
                'project_id' => $project->id(),
                'status_id' => 1,
                'tracker_id' => 1,
                'subject' => 'Last Issue via @aedart/athenaeum-redmine',
                'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
            ]
        ];

        $limit = 3;
        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, $id, Issue::class),
            $this->mockListOfResourcesResponse($list, Issue::class, 100, $limit),
            $this->mockDeletedResourceResponse()
        ]);

        // ----------------------------------------------------------------------- //
        // More prerequisites

        $issue = Issue::create($data, [], $connection);

        $this->assertNotEmpty($issue->id(), 'Issue was not created');

        // ----------------------------------------------------------------------- //
        // List Issues

        $issues = Issue::list($limit, 0, [], $connection);
        $this->assertGreaterThanOrEqual($limit - 1, count($issues->results()), 'Incorrect amount of issues returned');

        // ----------------------------------------------------------------------- //
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
            usleep(150_000);
        }

        // Debug
        // RedmineApiResource::$debug = false;
    }
}
