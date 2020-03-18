<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * D4_AuthorisationHeadersTest
 *
 * @group http-clients
 * @group http-clients-d4
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class D4_AuthorisationHeadersTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function sendsBasicAuthHeader(string $profile)
    {
        $client = $this->client($profile);

        $faker = $this->getFaker();

        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->useBasicAuth($faker->userName, $faker->password)
            ->get('/get');

        $headers = $this->lastRequest->getHeaders();
        ConsoleDebugger::output($headers);

        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertStringContainsString('Basic', $headers['Authorization'][0]);
    }

    // See Guzzle Specific Tests for Digest Auth...

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function sendsTokenAuthHeader(string $profile)
    {
        $client = $this->client($profile);

        $faker = $this->getFaker();
        $token = sha1($faker->password);

        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->useTokenAuth($token)
            ->get('/get');

        $headers = $this->lastRequest->getHeaders();
        ConsoleDebugger::output($headers);

        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertStringContainsString('Bearer', $headers['Authorization'][0]);
        $this->assertStringContainsString($token, $headers['Authorization'][0]);
    }
}
