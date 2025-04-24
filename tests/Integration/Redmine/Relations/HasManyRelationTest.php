<?php

namespace Aedart\Tests\Integration\Redmine\Relations;

use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Redmine\Issue;
use Aedart\Redmine\Project;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * HasManyRelationTest
 *
 * @group redmine
 * @group redmine-relations
 * @group redmine-relations-has-many
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Relations
 */
#[Group(
    'redmine',
    'redmine-relations',
    'redmine-relations-has-many',
)]
class HasManyRelationTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws ErrorResponseException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canObtainRelatedResources()
    {
        // Similar to the "belongs to" relation test(s), we also use a real resource
        // here, so that it can be testing in "live" mode.

        // Debug
        //        Project::$debug = true;

        // ------------------------------------------------------------------- //
        // Prerequisites - create a project with a few issues

        $projectId = 1234;
        $projectData = [
            'name' => 'Project with issues via @aedart/athenaeum-redmine',
            'identifier' => 'test-auto-created-' . now()->timestamp,
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];

        // Create the owning project
        $project = Project::create($projectData, [], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($projectData, $projectId, Project::class),
            $this->mockDeletedResourceResponse()
        ]));

        // Create a few issues, owned by the project
        $issueA = $this->createIssue($project->id());
        $issueB = $this->createIssue($project->id());
        $issueC = $this->createIssue($project->id());

        // ------------------------------------------------------------------- //
        // Obtain related resource

        // NOTE: Re-mock the connection, so that we can specify the related resource's data...
        $limit = 3;

        $list = [
            $issueA->toArray(),
            $issueB->toArray(),
            $issueC->toArray(),
        ];

        $relationConnection = $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, Issue::class, 100, $limit)
        ]);

        // Finally, obtain the related resource
        $issues = $project
            ->issues()
            ->usingConnection($relationConnection)
            ->limit(3)
            ->fetch();

        // ------------------------------------------------------------------- //
        // Assert found relation

        $this->assertNotEmpty($issues->results(), 'No results obtained');
        $this->assertSame($limit, $issues->limit(), 'Incorrect limit');

        foreach ($issues as $issue) {
            $this->assertInstanceOf(Issue::class, $issue);
        }

        // ------------------------------------------------------------------- //
        // Cleanup

        $issueA->delete();
        $issueB->delete();
        $issueC->delete();

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
    }

    /**
     * @test
     *
     * @throws ErrorResponseException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canFetchAllRelated()
    {
        // Similar to the "belongs to" relation test(s), we also use a real resource
        // here, so that it can be testing in "live" mode.

        // Debug
        //        Project::$debug = true;

        // ------------------------------------------------------------------- //
        // Prerequisites - create a project with a few issues

        $projectId = 1234;
        $projectData = [
            'name' => 'Project with issues via @aedart/athenaeum-redmine',
            'identifier' => 'test-auto-created-' . now()->timestamp,
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];

        // Create the owning project
        $project = Project::create($projectData, [], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($projectData, $projectId, Project::class),
            $this->mockDeletedResourceResponse()
        ]));

        // Create a few issues, owned by the project
        $issueA = $this->createIssue($project->id());
        $issueB = $this->createIssue($project->id());
        $issueC = $this->createIssue($project->id());
        $issueD = $this->createIssue($project->id());
        $issueE = $this->createIssue($project->id());
        $issueF = $this->createIssue($project->id());

        // ------------------------------------------------------------------- //
        // Obtain related resource

        $allList = [
            $issueA,
            $issueB,
            $issueC,
            $issueD,
            $issueE,
            $issueF,
        ];

        // The total expected amount of results
        $expectedTotal = count($allList);

        // The max. pool size / amount of records per results set
        // SHOULD result in exactly 4 requests.
        $size = 2;

        $relationConnection = $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse([ $issueA->toArray(), $issueB->toArray() ], Issue::class, $expectedTotal, $size, 0),
            $this->mockListOfResourcesResponse([ $issueC->toArray(), $issueD->toArray() ], Issue::class, $expectedTotal, $size, 2),
            $this->mockListOfResourcesResponse([ $issueE->toArray(), $issueF->toArray() ], Issue::class, $expectedTotal, $size, 4),
        ]);

        // Finally, obtain the related resource
        $issues = $project
            ->issues()
            ->usingConnection($relationConnection)
            ->fetchAll($size);

        // ----------------------------------------------------------------------- //
        // Assert traversable...

        // Ensure that it can be counted
        $this->assertCount($expectedTotal, $issues, 'Invalid amount of results available');

        // Ensure that we can loop through all results - that all requests are performed
        $c = 0;
        foreach ($issues as $issue) {
            $this->assertNotEmpty($issue->id());
            $c++;
        }

        $this->assertSame($expectedTotal, $c, 'Unexpected amount of iteration loops');

        // ----------------------------------------------------------------------- //
        // Cleanup

        foreach ($allList as $issue) {
            $issue->delete();
        }

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
    }
}
