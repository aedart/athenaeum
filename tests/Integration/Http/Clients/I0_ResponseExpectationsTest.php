<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ExpectationNotMetException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode;

/**
 * I0_ResponseExpectationsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-i0',
)]
class I0_ResponseExpectationsTest extends HttpClientsTestCase
{
    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canAddAndObtainExpectations(string $profile)
    {
        $expectations = [
            function (Status $status) {
                return true;
            },
            function (Status $status) {
                return true;
            },
            function (Status $status) {
                return true;
            },
        ];

        $builder = $this->client($profile)
            ->withExpectations($expectations);

        $this->assertTrue($builder->hasExpectations(), 'No expectations registered');
        $this->assertCount(count($expectations), $builder->getExpectations(), 'Incorrect amount of expectations');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function appliesExpectations(string $profile)
    {
        $hasAppliedA = false;
        $hasAppliedB = false;
        $hasAppliedC = false;

        $expectations = [
            function (Status $status) use (&$hasAppliedA) {
                $hasAppliedA = true;
            },
            function (Status $status) use (&$hasAppliedB) {
                $hasAppliedB = true;
            },
            function (Status $status) use (&$hasAppliedC) {
                $hasAppliedC = true;
            },
        ];

        $this->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withExpectations($expectations)
            ->get('/users');

        $this->assertTrue($hasAppliedA, 'expectation A not applied');
        $this->assertTrue($hasAppliedB, 'expectation B not applied');
        $this->assertTrue($hasAppliedC, 'expectation C not applied');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canExpectViaCallback(string $profile)
    {
        $hasApplied = false;

        $expectation = function () use (&$hasApplied) {
            $hasApplied = true;
        };

        $this->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->expect($expectation)
            ->get('/users');

        $this->assertTrue($hasApplied, 'has not applied callback expectation via "expect" method');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function failsWithExceptionWhenExpectationNotMet(string $profile)
    {
        $this->expectException(ExpectationNotMetException::class);

        $mock = $this->makeResponseMock([
            new Response(301)
        ]);

        $this->client($profile)
            ->withOption('handler', $mock)
            ->expect(200)
            ->get('/users');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function appliesOtherwiseCallbackWhenExpectationNotMet(string $profile)
    {
        $mock = $this->makeResponseMock([
            new Response(StatusCode::MOVED_PERMANENTLY)
        ]);

        $hasApplied = false;

        $otherwise = function () use (&$hasApplied) {
            $hasApplied = true;
        };

        $this->client($profile)
            ->withOption('handler', $mock)
            ->expect(StatusCode::OK, $otherwise)
            ->get('/users');

        $this->assertTrue($hasApplied, 'Otherwise callback not invoked');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function doesNothingWhenExpectationIsMet(string $profile)
    {
        $this->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->expect([StatusCode::CREATED, StatusCode::ACCEPTED, StatusCode::OK])
            ->get('/users');
    }
}
