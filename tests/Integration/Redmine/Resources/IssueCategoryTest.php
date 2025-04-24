<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\IssueCategory;
use Aedart\Redmine\Project;
use Aedart\Redmine\Version;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * IssueCategoryTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-issue-category
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-issue-category',
)]
class IssueCategoryTest extends RedmineTestCase
{
    /*****************************************************************
     * Helper
     ****************************************************************/

    /**
     * Creates a new issue category for given project
     *
     * @param Project $project
     * @param array $data [optional]
     *
     * @return IssueCategory
     *
     * @throws JsonException
     * @throws Throwable
     */
    public function createCategory(Project $project, array $data = []): IssueCategory
    {
        $faker = $this->getFaker();

        $data = array_merge([
            'name' => 'Test category ' . $faker->unique()->randomNumber(4) . ' @aedart/athenaeum-redmine',
        ], $data);

        $created = array_merge($data, [
            'project' => [ 'id' => $project->id(), 'name' => $project->name ]
        ]);

        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($created, $faker->unique()->randomNumber(4, true), IssueCategory::class),
            $this->mockDeletedResourceResponse()
        ]);

        return IssueCategory ::createForProject($project, $data, $connection);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canCreateIssueCategory()
    {
        // Debug
        //        IssueCategory::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites

        $project = $this->createProject();

        // -------------------------------------------------------- //
        // Create category

        $data = [
            'name' => 'Test Category via @aedart/athenaeum-redmine',
        ];
        $createdData = array_merge($data, [
            'project' => [ 'id' => $project->id, 'name' => $project->name ]
        ]);

        // (Re)Mock connection on project, to return new category response.
        // Connection is passed on to issue category resource...
        $originalConnection = $project->getConnection();
        $project->setConnection($this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($createdData, 1234, IssueCategory::class),
            $this->mockDeletedResourceResponse()
        ]));

        // Create version via the project's helper method!
        $category = $project->createIssueCategory($data);

        // -------------------------------------------------------- //
        // Assert created

        $this->assertSame($project->id(), $category->project->id, 'Incorrect project relation');
        $this->assertSame($data['name'], $category->name, 'Incorrect category name');

        // -------------------------------------------------------- //
        // Cleanup

        $category->delete();

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
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canUpdateIssueCategory()
    {
        // Debug
        //        IssueCategory::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites - create a new category

        $project = $this->createProject();
        $category = $this->createCategory($project);

        // -------------------------------------------------------- //
        // Update version

        $changed = [
            'name' => 'Category updated via @aedart/athenaeum-redmine'
        ];

        $connection = $this->liveOrMockedConnection([
            $this->mockUpdatedResourceResponse(),
            $this->mockReloadedResourceResponse($changed, 1234, IssueCategory::class),
            $this->mockDeletedResourceResponse()
        ]);

        $result = $category
            ->setConnection($connection)
            ->update($changed, true);

        // -------------------------------------------------------- //
        // Assert was updated

        $this->assertTrue($result, 'Version was not updated');
        $this->assertSame($changed['name'], $category->name, 'Category name was not updated');

        // -------------------------------------------------------- //
        // Cleanup

        $category->delete();

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
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canFetchIssueCategoriesForProject()
    {
        // Debug
        //        IssueCategory::$debug = true;

        // -------------------------------------------------------- //
        // Prerequisites - create a few categories for a project

        $project = $this->createProject();

        $categoryA = $this->createCategory($project);
        $categoryB = $this->createCategory($project);
        $categoryC = $this->createCategory($project);

        // -------------------------------------------------------- //
        // List categories for project

        // Mock list returned
        $limit = 3;
        $list = [
            $categoryA->toArray(),
            $categoryB->toArray(),
            $categoryC->toArray(),
        ];

        $relationConnection = $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, IssueCategory::class, 100, $limit)
        ]);

        // Fetch project's categories via custom relation
        $categories = $project
            ->issueCategories()
            ->usingConnection($relationConnection)
            ->limit($limit)
            ->fetch();

        // -------------------------------------------------------- //
        // Assert found relation

        $this->assertNotEmpty($categories->results(), 'No results obtained');

        // NOTE: ...Once again, Redmine does not care about pagination... damn it!
        //        $this->assertSame($limit, $categories->limit(), 'Incorrect limit');

        foreach ($categories as $category) {
            $this->assertInstanceOf(IssueCategory::class, $category);
        }

        // -------------------------------------------------------- //
        // Cleanup

        $categoryA->delete();
        $categoryB->delete();
        $categoryC->delete();

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
