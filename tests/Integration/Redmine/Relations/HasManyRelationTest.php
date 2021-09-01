<?php

namespace Aedart\Tests\Integration\Redmine\Relations;

use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Redmine\Issue;
use Aedart\Redmine\Project;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * HasManyRelationTest
 *
 * @group redmine
 * @group redmine-relations
 * @group redmine-relations-has-many
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Redmine\Relations
 */
class HasManyRelationTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws ErrorResponseException
     * @throws \JsonException
     * @throws \Throwable
     */
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

        $project->delete();
    }
}
