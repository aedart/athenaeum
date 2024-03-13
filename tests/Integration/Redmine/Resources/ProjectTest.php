<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Redmine\Project;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * ProjectTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-project
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class ProjectTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canCreateProject()
    {
        // Debug
        //        Project::$debug = true;

        // ----------------------------------------------------------------------- //

        $data = [
            'name' => 'Created via @aedart/athenaeum-redmine',
            'identifier' => 'test-auto-created-' . now()->timestamp,
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];

        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, Project::class),
            $this->mockDeletedResourceResponse()
        ]);

        // ----------------------------------------------------------------------- //

        $project = Project::create($data, [], $connection);

        $this->assertNotEmpty($project->id(), 'Project was not created');

        // ----------------------------------------------------------------------- //
        // Cleanup

        $project->delete();
    }

    /**
     * @test
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canUpdateProject()
    {
        // Debug
        //        Project::$debug = true;

        // ----------------------------------------------------------------------- //

        $data = [
            'name' => 'Created via @aedart/athenaeum-redmine',
            'identifier' => 'test-auto-created-' . now()->timestamp,
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];

        $changed = array_merge($data, [
            'name' => 'Updated via @aedart/athenaeum-redmine'
        ]);

        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, Project::class),
            $this->mockUpdatedResourceResponse(),
            $this->mockReloadedResourceResponse($changed, 1234, Project::class),
            $this->mockDeletedResourceResponse()
        ]);

        // ----------------------------------------------------------------------- //
        // Prerequisites

        $project = Project::create($data, [], $connection);

        $this->assertNotEmpty($project->id(), 'Project was not created');

        // ----------------------------------------------------------------------- //
        // Update

        $result = $project->update($changed, true);

        $this->assertTrue($result, 'Project was not updated');
        $this->assertSame($changed['name'], $project->name, 'Project name was not changed');

        // ----------------------------------------------------------------------- //
        // Cleanup

        $project->delete();
    }

    /**
     * @test
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canListProjects()
    {
        // Debug
        //        Project::$debug = true;

        // ----------------------------------------------------------------------- //

        $id = 1234;
        $data = [
            'name' => 'Created via @aedart/athenaeum-redmine',
            'identifier' => 'test-auto-created-' . now()->timestamp,
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];

        $list = [
            array_merge($data, [ 'id' => $id ]),
            [
                'id' => 4321,
                'name' => 'Another project',
                'identifier' => 'another-' . now()->timestamp,
                'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
            ],
            [
                'id' => 5555,
                'name' => 'Special project',
                'identifier' => 'special-' . now()->timestamp,
                'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
            ]
        ];

        $limit = 3;
        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, $id, Project::class),
            $this->mockListOfResourcesResponse($list, Project::class, 100, $limit),
            $this->mockDeletedResourceResponse()
        ]);

        // ----------------------------------------------------------------------- //
        // Prerequisites

        $project = Project::create($data, [], $connection);

        $this->assertNotEmpty($project->id(), 'Project was not created');

        // ----------------------------------------------------------------------- //
        // List Projects

        $projects = Project::list($limit, 0, [], $connection);

        $this->assertGreaterThanOrEqual(1, count($projects->results()), 'Incorrect amount of projects returned');

        // ----------------------------------------------------------------------- //
        // Cleanup

        $project->delete();
    }
}
