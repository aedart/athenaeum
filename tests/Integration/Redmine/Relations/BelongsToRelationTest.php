<?php

namespace Aedart\Tests\Integration\Redmine\Relations;

use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Redmine\Project;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * BelongsToRelationTest
 *
 * @group redmine
 * @group redmine-relations
 * @group redmine-relations-belongs-to
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Relations
 */
class BelongsToRelationTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws ErrorResponseException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canObtainRelatedResource()
    {
        // The easiest way to ensure that belongs to relation works as intended,
        // if by using it directly on one of the existing predefined resources.
        // If testing runs in "live" mode, then actual resources are used.

        // Debug
        //        Project::$debug = true;

        // ------------------------------------------------------------------- //
        // Prerequisites - create two resources that are related to each other

        $parentId = 1234;
        $parentData = [
            'name' => 'Parent project via @aedart/athenaeum-redmine',
            'identifier' => 'test-auto-created-' . now()->timestamp,
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.'
        ];

        // Create the parent
        $parent = Project::create($parentData, [], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($parentData, $parentId, Project::class),
            $this->mockDeletedResourceResponse()
        ]));

        // Create child
        $childId = 4321;
        $childData = [
            'name' => 'Child project via @aedart/athenaeum-redmine',
            'identifier' => 'test-auto-created-' . now()->addSeconds(1)->timestamp,
            'description' => 'Projects are been created via Redmine API Client, in [Athenaeum](https://github.com/aedart/athenaeum) package.',
            'parent_id' => $parent->id(),
        ];
        $childCreatedData = array_merge($childData, [
            'parent' => [ 'id' => $parent->id(), 'name' => $parent->name ],
        ]);

        $child = Project::create($childData, [], $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($childCreatedData, $childId, Project::class),
            $this->mockDeletedResourceResponse()
        ]));

        // ------------------------------------------------------------------- //
        // Obtain related resource

        // NOTE: Re-mock the connection, so that we can specify the related resource's data...
        $relatedParentData = array_merge($parentData, [
            'trackers' => []
        ]);
        $relationConnection = $this->liveOrMockedConnection([
            $this->mockSingleResourceResponse($relatedParentData, $parent->id(), Project::class)
        ]);

        // Finally, obtain the related resource
        /** @var Project $related */
        $related = $child
            ->parent()
            ->usingConnection($relationConnection)
            ->include(['trackers'])
            ->fetch();

        // ------------------------------------------------------------------- //
        // Assert found relation

        $this->assertSame($parent->id(), $related->id(), 'Invalid parent relation returned!');
        $this->assertTrue(isset($related->trackers), 'Include filter not applied');

        // ------------------------------------------------------------------- //
        // Cleanup

        $child->delete();
        $parent->delete();
    }
}
