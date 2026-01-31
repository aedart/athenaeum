<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\Exceptions\NotFound;
use Aedart\Redmine\RedmineApiResource;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode\All as StatusCodes;
use Throwable;

/**
 * FetchAndFindTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-list',
    'redmine-resources-fetch',
    'redmine-resources-fetch-multiple',
    'redmine-resources-find',
)]
class FetchAndFindTest extends RedmineTestCase
{
    #[Test]
    public function canFetchMultipleViaList()
    {
        $amount = 8;
        $total = 150;
        $limit = 8;
        $offset = 3;
        $payload = $this->makePaginatedDummyPayload($amount, $total, $limit, $offset);

        $connection = $this->connectionWithMock($payload);

        $list = DummyResource::list($limit, $offset, [], $connection);

        // --------------------------------------------------- //
        // Resources returned

        $collection = $list->results();

        $this->assertCount($amount, $collection, 'Incorrect amount results in collection');

        foreach ($collection as $resource) {
            $this->assertInstanceOf(DummyResource::class, $resource);
        }

        // --------------------------------------------------- //
        // Pagination details

        $this->assertSame($total, $list->total(), 'Incorrect total returned');
        $this->assertSame($limit, $list->limit(), 'Incorrect limit returned');
        $this->assertSame($offset, $list->offset(), 'Incorrect offset returned');
    }

    /**
     * @throws ConnectionException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canFindSingleResource()
    {
        $id = 1324;
        $payload = $this->makeSingleDummyResponsePayload([ 'id' => $id ]);
        $connection = $this->connectionWithMock($payload);

        $result = DummyResource::find($id, [], $connection);

        // --------------------------------------------------- //

        $this->assertNotNull($result);
        $this->assertInstanceOf(DummyResource::class, $result);
        $this->assertSame($id, $result->id());
    }

    /**
     * @throws ConnectionException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function failsWhenResourceDoesNotExist()
    {
        $this->expectException(NotFound::class);

        $connection = $this->connectionWithMock([], StatusCodes::NOT_FOUND);

        DummyResource::findOrFail(4321, [], $connection);
    }

    /**
     * @throws ConnectionException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function findReturnsNullWhenResourceDoesNotExist()
    {
        $connection = $this->connectionWithMock([], StatusCodes::NOT_FOUND);

        $result = DummyResource::find(4321, [], $connection);

        $this->assertNull($result);
    }

    /**
     * @throws UnsupportedOperationException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function failsIfDoesNotSupportListingOperation()
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

        $resourceClass::fetchMultiple();
    }
}
