<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode\All as StatusCodes;
use Throwable;

/**
 * CreateTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-create',
)]
class CreateTest extends RedmineTestCase
{
    /**
     * @throws ConnectionException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
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
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
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
