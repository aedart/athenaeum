<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Aedart\Redmine\Exceptions\NotFound;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Teapot\StatusCode\All as StatusCodes;

/**
 * FetchAndFindTest
 *
 * @group redmine
 * @group redmine-resource
 * @group redmine-resource-list
 * @group redmine-resource-fetch
 * @group redmine-resource-fetch-multiple
 * @group redmine-resource-find
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Redmine
 */
class FetchAndFindTest extends RedmineTestCase
{
    /**
     * @test
     */
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
     * @test
     *
     * @throws ConnectionException
     * @throws \JsonException
     * @throws \Throwable
     */
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
     * @test
     *
     * @throws ConnectionException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function failsWhenResourceDoesNotExist()
    {
        $this->expectException(NotFound::class);

        $connection = $this->connectionWithMock([], StatusCodes::NOT_FOUND);

        DummyResource::findOrFail(4321, [], $connection);
    }

    /**
     * @test
     *
     * @throws ConnectionException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function findReturnsNullWhenResourceDoesNotExist()
    {
        $connection = $this->connectionWithMock([], StatusCodes::NOT_FOUND);

        $result = DummyResource::find(4321, [], $connection);

        $this->assertNull($result);
    }
}
