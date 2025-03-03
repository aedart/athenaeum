<?php

namespace Aedart\Tests\Integration\Redmine\Pagination;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Issue;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use JsonException;
use Throwable;

/**
 * TraversableResultsTest
 *
 * @group redmine
 * @group redmine-pagination
 * @group redmine-pagination-traversable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Pagination
 */
class TraversableResultsTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    public function canTraverseAcrossMultipleApiResultsPages()
    {
        // Debug
        // RedmineApiResource::$debug = true;

        // ----------------------------------------------------------------------- //
        // Prerequisites - Create a large enough issue set, so that the traversable
        // if forced to paginate results

        $project = $this->createProject();

        $issueA = $this->createIssue($project->id());
        $issueB = $this->createIssue($project->id());
        $issueC = $this->createIssue($project->id());
        $issueD = $this->createIssue($project->id());
        $issueE = $this->createIssue($project->id());
        $issueF = $this->createIssue($project->id());
        $issueG = $this->createIssue($project->id());

        $allList = [
            $issueA,
            $issueB,
            $issueC,
            $issueD,
            $issueE,
            $issueF,
            $issueG,
        ];

        // ----------------------------------------------------------------------- //
        // Fetch all results

        // The total expected amount of results
        $expectedTotal = count($allList);

        // The max. pool size / amount of records per results set
        // SHOULD result in exactly 4 requests.
        $size = 2;

        // VERY IMPORTANT (at least for live tests) a filter to limit
        // the issues to the ones we have just created
        $filter = function (Builder $request) use ($project) {
            return $request
                ->where('project_id', $project->id());
        };

        $issues = Issue::all($filter, $size, $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse([ $issueA->toArray(), $issueB->toArray() ], Issue::class, $expectedTotal, $size, 0),
            $this->mockListOfResourcesResponse([ $issueC->toArray(), $issueD->toArray() ], Issue::class, $expectedTotal, $size, 2),
            $this->mockListOfResourcesResponse([ $issueE->toArray(), $issueF->toArray() ], Issue::class, $expectedTotal, $size, 4),
            $this->mockListOfResourcesResponse([ $issueG->toArray() ], Issue::class, $expectedTotal, $size, 6),
        ]));

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

        $project->delete();

        // Debug
        // RedmineApiResource::$debug = false;
    }
}
