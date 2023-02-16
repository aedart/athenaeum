<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Teapot\StatusCode\All as StatusCodes;

/**
 * CreateTest
 *
 * @group redmine
 * @group redmine-resource
 * @group redmine-resource-create
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine
 */
class CreateTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws ConnectionException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canCreateNewResource()
    {
        $faker = $this->getFaker();

        $id = $faker->randomNumber(4, true);
        $name = $faker->name;
        $responsePayload = $this->makeSingleDummyResponsePayload([ 'id' => $id, 'name' => $name ]);

        $connection = $this->connectionWithMock($responsePayload, StatusCodes::CREATED);

        $resource = DummyResource::create([ 'name' => $name ], [], $connection);

        // ----------------------------------------------------------------- //

        $this->assertTrue(isset($resource->id), 'No id set');
        $this->assertSame($id, $resource->id);
        $this->assertSame($name, $resource->name);
    }

    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function failsIfDoesNotSupportCreateOperation()
    {
        $this->expectException(UnsupportedOperationException::class);

        $resourceClass = new class() extends RedmineApiResource {
            protected array $allowed = [ 'name' => 'string' ];

            public function resourceName(): string
            {
                return 'some-resources';
            }
        };

        $resourceClass::create([ 'name' => 'Jane' ]);
    }
}
