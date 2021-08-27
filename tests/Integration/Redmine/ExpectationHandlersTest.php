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
use Teapot\StatusCode\All as StatusCodes;

/**
 * ExpectationHandlersTest
 *
 * @group redmine
 * @group redmine-resource
 * @group redmine-resource-expectation-handlers
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Redmine
 */
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
     * @test
     * @dataProvider responseExpectations
     *
     * @param int $responseStatusCode
     * @param string $expectedException
     *
     * @throws ConnectionException
     * @throws ErrorResponseException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function appliesDefaultResponseExpectationHandler(int $responseStatusCode, string $expectedException)
    {
        $this->expectException($expectedException);

        $connection = $this->connectionWithMock([], $responseStatusCode);

        DummyResource::fetch(1234, null, $connection);
    }

    /**
     * @test
     *
     * @throws ConnectionException
     * @throws \JsonException
     * @throws \Throwable
     */
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
