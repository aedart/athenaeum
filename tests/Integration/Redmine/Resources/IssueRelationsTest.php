<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Issue;
use Aedart\Redmine\Relation;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * IssueRelationsTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-issue-relations
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class IssueRelationsTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canRelateIssues()
    {
        // Debug
        //        Issue::$debug = true;

        // ----------------------------------------------------------------------- //
        // Prerequisites
        $project = $this->createProject();

        // ----------------------------------------------------------------------- //
        // Create two issues

        $parentId = 1234;
        $relatedId = 4321;
        $data = [
            'project_id' => $project->id(),
            'status_id' => 1,
            'tracker_id' => 1,
            'subject' => 'Issue via @aedart/athenaeum-redmine',
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];
        $relationData = [
            'id' => 8754,
            'issue_id' => $parentId,
            'issue_to_id' => $relatedId,
            'relation_type' => Relation::RELATES,
        ];

        $issueA = Issue::create($data, [], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, $parentId, Issue::class),
            $this->mockCreatedResourceResponse($relationData, 8754, Relation::class),
            $this->mockDeletedResourceResponse(),
            $this->mockDeletedResourceResponse(),
        ]));

        $issueB = Issue::create($data, [], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, $relatedId, Issue::class),
            $this->mockDeletedResourceResponse(),
        ]));

        // ----------------------------------------------------------------------- //
        // Related the issues

        $relation = $issueA->addRelation($issueB);

        $this->assertNotEmpty($relation->id(), 'Created relation has no id!?!');
        $this->assertSame($issueA->id(), $relation->issue_id, 'Incorrect parent');
        $this->assertSame($issueB->id(), $relation->issue_to_id, 'Incorrect related id');

        // ----------------------------------------------------------------------- //
        // Cleanup

        $relation->delete();
        $issueA->delete();
        $issueB->delete();
        $project->delete();
    }
}
