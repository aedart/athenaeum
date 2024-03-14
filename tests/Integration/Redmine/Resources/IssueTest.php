<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Issue;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * IssueTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-issue
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class IssueTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws \JsonException
     * @throws \Throwable
     */
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
        $project->delete();
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
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
        $project->delete();
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canListIssues()
    {
        // Debug
        //        Issue::$debug = true;

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

        $this->assertCount($limit, $issues->results(), 'Incorrect amount of issues returned');

        // ----------------------------------------------------------------------- //
        // Cleanup

        $issue->delete();
        $project->delete();
    }
}
