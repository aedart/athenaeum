<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Tracker;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * TrackerTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-trackers
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class TrackerTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canListTrackers()
    {
        // Debug
        //        Tracker::$debug = true;

        // ---------------------------------------------------------- //
        // List trackers

        $list = [
            [
                'id' => 1,
                'name' => 'feature',
//                'description' => 'Lorum lipsum',
                'default_status' => [ 'id' => 1, 'name' => 'New' ],
//                'enabled_standard_fields' => '???'
            ],
            [
                'id' => 2,
                'name' => 'bug',
//                'description' => 'Lorum lipsum',
                'default_status' => [ 'id' => 1, 'name' => 'New' ],
//                'enabled_standard_fields' => '???'
            ],
            [
                'id' => 3,
                'name' => 'document',
//                'description' => 'Lorum lipsum',
                'default_status' => [ 'id' => 1, 'name' => 'New' ],
//                'enabled_standard_fields' => '???'
            ],
        ];

        $trackers = Tracker::list(10, 0, [], $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, Tracker::class)
        ]));

        // ---------------------------------------------------------- //
        // Assert found

        $this->assertNotEmpty($trackers->results(), 'No tracker returned');
        foreach ($trackers as $tracker) {
            $this->assertInstanceOf(Tracker::class, $tracker);
        }
    }
}
