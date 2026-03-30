<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Redmine\Exceptions\Conflict;
use Aedart\Redmine\Exceptions\NotFound;
use Aedart\Redmine\Exceptions\UnexpectedResponse;
use Aedart\Redmine\Exceptions\UnprocessableEntity;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode\All as StatusCodes;
use Throwable;

/**
 * ExpectationHandlersTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-expectation-handlers',
)]
class ExpectationHandlersTest extends RedmineTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Data provider for default response expectations
     *
     * @return array[]
     */
    public function responseExpectations(): array
    {
        return [
            // Common expected statuses...
            'Status ' . StatusCodes::NOT_FOUND => [ StatusCodes::NOT_FOUND,  NotFound::class ],
            'Status ' . StatusCodes::UNPROCESSABLE_ENTITY => [ StatusCodes::UNPROCESSABLE_ENTITY,  UnprocessableEntity::class ],
            'Status ' . StatusCodes::CONFLICT => [ StatusCodes::CONFLICT,  Conflict::class ],

            // Unexpected statuses...
            'Status ' . StatusCodes::INTERNAL_SERVER_ERROR => [ StatusCodes::INTERNAL_SERVER_ERROR,  UnexpectedResponse::class ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @param int $responseStatusCode
     * @param string $expectedException
     *
     * @throws ConnectionException
     * @throws ErrorResponseException
     * @throws JsonException
     * @throws Throwable
     */
    #[DataProvider('responseExpectations')]
    #[Test]
    public function appliesDefaultResponseExpectationHandler(int $responseStatusCode, string $expectedException)
    {
        $this->expectException($expectedException);

        $connection = $this->connectionWithMock([], $responseStatusCode);

        DummyResource::fetch(1234, null, $connection);
    }

    /**
     * @throws ConnectionException
     * @throws JsonException
     * @throws Throwable
     */
    #[Test]
    public function canUseCustomExpectationHandler()
    {
        $connection = $this->connectionWithMock([], StatusCodes::SERVICE_UNAVAILABLE);

        $resource = DummyResource::make([], $connection);

        $hasInvokedHandler = false;
        $resource->useFailedExpectationHandler(function () use (&$hasInvokedHandler) {
            $hasInvokedHandler = true;
        });

        $resource
            ->request()
            ->get('/users');

        // --------------------------------------------------------- //

        $this->assertTrue($hasInvokedHandler);
    }
}
