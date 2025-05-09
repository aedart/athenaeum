<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Contracts\Redmine\Exceptions\RedmineException;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\DocumentCategory;
use Aedart\Redmine\Enumeration;
use Aedart\Redmine\IssuePriority;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Redmine\TimeEntryActivity;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * EnumerationResourcesTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-enum
 * @group redmine-resources-issue-priority
 * @group redmine-resources-time-entry-activity
 * @group redmine-resources-doc-category
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-enum',
    'redmine-resources-issue-priority',
    'redmine-resources-time-entry-activity',
    'redmine-resources-doc-category',
)]
class EnumerationResourcesTest extends RedmineTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides enumeration resources
     *
     * @return array
     */
    public function providesEnumerationResources(): array
    {
        return [
            'IssuePriority' => [ IssuePriority::class ],
            'TimeEntryActivity' => [ TimeEntryActivity::class ],
            'DocumentCategory' => [ DocumentCategory::class ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesEnumerationResources
     *
     * @param class-string<Enumeration> $enumerationResource Class path
     *
     * @throws JsonException
     * @throws ErrorResponseException
     * @throws RedmineException
     * @throws UnsupportedOperationException
     * @throws Throwable
     */
    #[DataProvider('providesEnumerationResources')]
    #[Test]
    public function canListEnumeration(string $enumerationResource)
    {
        // Debug
        // RedmineApiResource::$debug = true;

        $list = [
            [
                'id' => 1,
                'name' => 'a',
                'is_default' => false
            ],
            [
                'id' => 2,
                'name' => 'b',
                'is_default' => true
            ],
            [
                'id' => 3,
                'name' => 'c',
                'is_default' => false
            ],
        ];

        $found = $enumerationResource::fetchMultiple(null, 10, 0, $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, $enumerationResource)
        ]));

        // ---------------------------------------------------------- //
        // Assert found

        $this->assertNotEmpty($found->results(), 'No resources returned');
        foreach ($found as $resource) {
            $this->assertInstanceOf($enumerationResource, $resource);
        }

        // Debug
        // RedmineApiResource::$debug = false;
    }
}
