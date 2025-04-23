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
 * UpdateTest
 *
 * @group redmine
 * @group redmine-resource
 * @group redmine-resource-update
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-update'
)]
class UpdateTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws ConnectionException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canUpdateExistingResource()
    {
        $name = $this->getFaker()->name();

        $connection = $this->connectionWithMock([], StatusCodes::OK);

        $resource = $this->makeDummyResource([ 'id' => 1234 ], $connection);
        $result = $resource->update([ 'name' => $name ]);

        // ----------------------------------------------------------------- //

        $this->assertTrue($result, 'Failed to update resource');
        $this->assertSame($name, $resource->name);
    }

    /**
     * @test
     *
     * @throws ConnectionException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canUpdateAndReload()
    {
        $name = $this->getFaker()->name();
        $reloadedName = strtoupper($name); // Just for the sake of the test... Not expecting Redmine to do this...
        $payload = $this->makeSingleDummyResponsePayload([ 'name' => $reloadedName ]);

        // ----------------------------------------------------------------- //

        $updatedResponse = $this->mockJsonResponse();
        $reloadedResponse = $this->mockJsonResponse($payload);

        $connection = $this->connectWithMultipleMocks([
            $updatedResponse,
            $reloadedResponse
        ]);

        // ----------------------------------------------------------------- //
        // Update & reload

        $resource = $this->makeDummyResource([ 'id' => 1234 ], $connection);
        $result = $resource->update([ 'name' => $name ], true);

        // ----------------------------------------------------------------- //

        $this->assertTrue($result, 'Failed to update resource');
        $this->assertSame($reloadedName, $resource->name);
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function failsIfDoesNotSupportUpdateOperation()
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

        $resource = $resourceClass::make([ 'id' => 1234, 'name' => 'Brian' ]);
        $resource->update([ 'name' => 'Brian Jr.' ]);
    }
}
