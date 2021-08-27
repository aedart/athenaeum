<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Teapot\StatusCode\All as StatusCodes;

/**
 * UpdateTest
 *
 * @group redmine
 * @group redmine-resource
 * @group redmine-resource-update
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Redmine
 */
class UpdateTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws ConnectionException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canUpdateExistingResource()
    {
        $name = $this->getFaker()->name;

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
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canUpdateAndReload()
    {
        $name = $this->getFaker()->name;
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
}
