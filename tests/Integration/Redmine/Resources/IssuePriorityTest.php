<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\IssuePriority;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * IssuePriorityTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-issue-priority
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class IssuePriorityTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canListPriorities()
    {
        // Debug
//        IssuePriority::$debug = true;

        // ---------------------------------------------------------- //
        // List issue priorities

        $list = [
            [
                'id' => 1,
                'name' => 'low',
                'is_default' => false
            ],
            [
                'id' => 2,
                'name' => 'medium',
                'is_default' => true
            ],
            [
                'id' => 3,
                'name' => 'high',
                'is_default' => false
            ],
        ];

        $trackers = IssuePriority::list(10, 0, [], $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, IssuePriority::class)
        ]));

        // ---------------------------------------------------------- //
        // Assert found

        $this->assertNotEmpty($trackers->results(), 'No issue priorities returned');
        foreach ($trackers as $tracker) {
            $this->assertInstanceOf(IssuePriority::class, $tracker);
        }
    }
}
