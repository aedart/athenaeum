<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\IssueStatus;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * IssueStatusTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-issue-status
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-issue-status',
)]
class IssueStatusTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canListIssueStatuses()
    {
        // Debug
        //        IssueStatus::$debug = true;

        // ---------------------------------------------------------- //
        // List statuses

        $list = [
            [
                'id' => 1,
                'name' => 'New',
                'is_closed' => false
            ],
            [
                'id' => 2,
                'name' => 'In Progress',
                'is_closed' => false
            ],
            [
                'id' => 3,
                'name' => 'Done',
                'is_closed' => true
            ],
        ];

        $statuses = IssueStatus::list(10, 0, [], $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, IssueStatus::class)
        ]));

        // ---------------------------------------------------------- //
        // Assert found statuses

        $this->assertNotEmpty($statuses->results(), 'No issue statuses returned');
        foreach ($statuses as $status) {
            $this->assertInstanceOf(IssueStatus::class, $status);
        }
    }
}
