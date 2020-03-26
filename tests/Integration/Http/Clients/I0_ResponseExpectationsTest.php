<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * I0_ResponseExpectationsTest
 *
 * @group http-clients
 * @group http-clients-i0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class I0_ResponseExpectationsTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
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
        $this->assertSame($expectations, $builder->getExpectations(), 'Incorrect expectations returned');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
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
}
