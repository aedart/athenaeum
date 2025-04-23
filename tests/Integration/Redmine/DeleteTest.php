<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode\All as StatusCodes;
use Throwable;

/**
 * DeleteTest
 *
 * @group redmine
 * @group redmine-resource
 * @group redmine-resource-delete
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-delete',
)]
class DeleteTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws ConnectionException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canDeleteResource()
    {
        $connection = $this->connectionWithMock();

        $resource = $this->makeDummyResource([ 'id' => 1234 ], $connection);

        $result = $resource->delete();
        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @throws ConnectionException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function returnsFalseWhenDoesNotExist()
    {
        // Mock response - if delete method sends a request, then
        // this test will fail with an "unexpected response" exception
        $connection = $this->connectionWithMock([], StatusCodes::SERVICE_UNAVAILABLE);

        $resource = $this->makeDummyResource([], $connection);

        $result = $resource->delete();
        $this->assertFalse($result);
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function failsIfDoesNotSupportDeleteOperation()
    {
        $this->expectException(UnsupportedOperationException::class);

        $resourceClass = new class() extends RedmineApiResource {
            protected array $allowed = [
                'id' => 'string',
                'name' => 'string'
            ];

            public function resourceName(): string
            {
                return 'some-resources';
            }
        };

        $resource = $resourceClass::make([ 'id' => 1234, 'name' => 'Jane' ]);
        $resource->delete();
    }
}
