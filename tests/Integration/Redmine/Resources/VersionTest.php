<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Project;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Redmine\Version;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * VersionTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-version
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class VersionTest extends RedmineTestCase
{
    /*****************************************************************
     * Helper
     ****************************************************************/

    /**
     * Creates a new version for given project
     *
     * @param Project $project
     *
     * @return Version
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public function createVersion(Project $project): Version
    {
        $faker = $this->getFaker();

        $data = [
            'name' => $faker->unique()->numerify('#.#.#'),
            'description' => 'Milestone version created via @aedart/athenaeum-redmine'
        ];

        $created = array_merge($data, [
            'project' => [ 'id' => $project->id(), 'name' => $project->name ]
        ]);

        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($created, $faker->unique()->randomNumber(4, true), Version::class),
            $this->mockDeletedResourceResponse()
        ]);

        return Version::createForProject($project, $data, $connection);
    }

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
    public function canCreateVersion()
    {
        // Debug
        // RedmineApiResource::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites

        $project = $this->createProject();

        // -------------------------------------------------------- //
        // Create version

        $data = [
            'name' => '0.1',
            'description' => 'Milestone version created via @aedart/athenaeum-redmine'
        ];
        $createdData = array_merge($data, [
            'project' => [ 'id' => $project->id, 'name' => $project->name ]
        ]);

        // (Re)Mock connection on project, to return new version response.
        // Connection is passed on to version resource...
        $originalConnection = $project->getConnection();
        $project->setConnection($this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($createdData, 1234, Version::class),
            $this->mockDeletedResourceResponse()
        ]));

        // Create version via the project's helper method!
        $version = $project->createVersion($data);

        // -------------------------------------------------------- //
        // Assert created version

        $this->assertSame($project->id(), $version->project->id, 'Incorrect project relation');
        $this->assertSame($data['name'], $version->name, 'Incorrect version name');
        $this->assertSame($data['description'], $version->description, 'Incorrect version name');

        // -------------------------------------------------------- //
        // Cleanup

        $version->delete();

        $project->setConnection($originalConnection);
        $project->delete();

        // Debug
        // RedmineApiResource::$debug = false;
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canUpdateVersion()
    {
        // Debug
        //        Version::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites - create a new version

        $project = $this->createProject();

        $version = $this->createVersion($project);

        // -------------------------------------------------------- //
        // Update version

        $changed = [
            'description' => 'Milestone version updated via @aedart/athenaeum-redmine'
        ];

        $connection = $this->liveOrMockedConnection([
            $this->mockUpdatedResourceResponse(),
            $this->mockReloadedResourceResponse($changed, 1234, Version::class),
            $this->mockDeletedResourceResponse()
        ]);

        $result = $version
            ->setConnection($connection)
            ->update($changed, true);

        // -------------------------------------------------------- //
        // Assert was updated

        $this->assertTrue($result, 'Version was not updated');
        $this->assertSame($changed['description'], $version->description, 'Version description was not updated');

        // -------------------------------------------------------- //
        // Cleanup

        $version->delete();
        $project->delete();
    }

    /**
     * @test
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canFetchVersionsForProject()
    {
        // Debug
        //        Version::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites - create a few versions for a project

        $project = $this->createProject();

        $versionA = $this->createVersion($project);
        $versionB = $this->createVersion($project);
        $versionC = $this->createVersion($project);

        // -------------------------------------------------------- //
        // List versions for project

        // Mock versions list returned
        $limit = 3;

        $list = [
            $versionA->toArray(),
            $versionB->toArray(),
            $versionC->toArray(),
        ];

        $relationConnection = $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, Version::class, 100, $limit)
        ]);

        // Fetch project's versions via custom relation
        $versions = $project
            ->versions()
            ->usingConnection($relationConnection)
            ->limit($limit)
            ->fetch();

        // -------------------------------------------------------- //
        // Assert found relation

        $this->assertNotEmpty($versions->results(), 'No results obtained');
        $this->assertSame($limit, $versions->limit(), 'Incorrect limit');

        foreach ($versions as $version) {
            $this->assertInstanceOf(Version::class, $version);
        }

        // -------------------------------------------------------- //
        // Cleanup

        $versionA->delete();
        $versionB->delete();
        $versionC->delete();

        $project->delete();
    }
}
