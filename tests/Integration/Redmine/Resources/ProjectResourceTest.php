<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Redmine\Project;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * ProjectResourceTest
 *
 * @group redmine
 * @group redmine-resources
 * @group project-resource
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class ProjectResourceTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canListProjects()
    {
        $this->markTestSkipped('Incomplete');

        $list = Project::list(5, 0, ['trackers', 'issue_categories', 'enabled_modules', 'time_entry_activities']);
//        $list = Project::findOrFail('aretaeus', ['trackers']);

//        foreach ($list as $project) {
//            foreach ($project->trackers as $tracker) {
//                $tracker->name;
//            }
//        }

//        dump($list->toArray());
        dump($list->toJson(JSON_PRETTY_PRINT));
    }
}
