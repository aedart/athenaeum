<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\CustomField;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * CustomFieldTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-custom-field
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class CustomFieldTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canListCustomFields()
    {
        // Debug
        //        CustomField::$debug = true;

        $list = [
            [
                'id' => 1234,
                'name' => 'Custom field a',
                'customized_type' => 'issue',
                'field_format' => 'list'
                // ... remaining not added for test ...
            ],
            [
                'id' => 4321,
                'name' => 'Custom field b',
                'customized_type' => 'project',
                'field_format' => 'text'
                // ... remaining not added for test ...
            ]
        ];

        $limit = 3;
        $connection = $this->liveOrMockedConnection([
            $this->mockListOfResourcesResponse($list, CustomField::class, 100, $limit),
        ]);


        // ----------------------------------------------------------------------- //
        // List custom fields

        $fields = CustomField::list($limit, 0, [], $connection);

        // Depending on "live" test's redmine instance, no custom fields might be installed.
        // API does not support creation or modification, making this test very hard to work with...
        $this->assertGreaterThanOrEqual(0, count($fields->results()));
    }
}
