<?php

namespace Aedart\Tests\Integration\Redmine\Pagination;

use Aedart\Redmine\Collections\Collection;
use Aedart\Redmine\Pagination\PaginatedResults;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * PaginatedResultsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Pagination
 */
#[Group(
    'redmine',
    'redmine-pagination',
)]
class PaginatedResultsTest extends RedmineTestCase
{
    /**
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canCreateFromResponse()
    {
        $dummies = $this->makePaginatedDummyPayload();
        $response = $this->mockJsonResponse($dummies);

        $results = PaginatedResults::fromResponse($response, $this->makeDummyResource());

        $this->assertNotNull($results);
    }

    /**
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function hasPaginationInformation()
    {
        $total = 67;
        $limit = 3;
        $offset = 15;

        $dummies = $this->makePaginatedDummyPayload($limit, $total, $limit, $offset);
        $response = $this->mockJsonResponse($dummies);

        $results = PaginatedResults::fromResponse($response, $this->makeDummyResource());

        $this->assertSame($total, $results->total(), 'total not set');
        $this->assertSame($limit, $results->limit(), 'limit not set');
        $this->assertSame($offset, $results->offset(), 'offset not set');
    }

    /**
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function iterateThroughResults()
    {
        $amount = 5;
        $dummies = $this->makePaginatedDummyPayload($amount);
        $response = $this->mockJsonResponse($dummies);

        $results = PaginatedResults::fromResponse($response, $this->makeDummyResource());

        foreach ($results as $resource) {
            $this->assertInstanceOf(DummyResource::class, $resource);
        }
    }

    /**
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canObtainResultsCollection()
    {
        $dummies = $this->makePaginatedDummyPayload();
        $response = $this->mockJsonResponse($dummies);

        $results = PaginatedResults::fromResponse($response, $this->makeDummyResource());
        $collection = $results->results();

        $this->assertInstanceOf(Collection::class, $collection);
    }

    /**
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canExportArray()
    {
        $dummies = $this->makePaginatedDummyPayload();
        $response = $this->mockJsonResponse($dummies);

        $results = PaginatedResults::fromResponse($response, $this->makeDummyResource());

        $exported = $results->toArray();

        ConsoleDebugger::output($exported);

        $this->assertNotEmpty($exported);
    }

    /**
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canExportToJson()
    {
        $dummies = $this->makePaginatedDummyPayload();
        $response = $this->mockJsonResponse($dummies);

        $results = PaginatedResults::fromResponse($response, $this->makeDummyResource());

        $exported = $results->toJson();

        ConsoleDebugger::output($exported);

        $this->assertJson($exported);
    }

    /**
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canBeJsonEncoded()
    {
        $dummies = $this->makePaginatedDummyPayload();
        $response = $this->mockJsonResponse($dummies);

        $results = PaginatedResults::fromResponse($response, $this->makeDummyResource());

        $encoded = Json::encode($results, JSON_PRETTY_PRINT);

        ConsoleDebugger::output($encoded);

        $this->assertJson($encoded);
    }

    /**
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canBeConvertedToString()
    {
        $dummies = $this->makePaginatedDummyPayload();
        $response = $this->mockJsonResponse($dummies);

        $results = PaginatedResults::fromResponse($response, $this->makeDummyResource());

        $converted = (string) $results;

        ConsoleDebugger::output($converted);

        $this->assertJson($converted);
    }
}
