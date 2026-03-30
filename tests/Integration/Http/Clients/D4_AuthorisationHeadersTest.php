<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;

/**
 * D4_AuthorisationHeadersTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-d4',
)]
class D4_AuthorisationHeadersTest extends HttpClientsTestCase
{
    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function sendsDigestAuthHeader(string $profile)
    {
        // This test is is inspired by Guzzle's own way of testing
        // digest authentication requests.
        // @see https://github.com/guzzle/guzzle/blob/master/tests/ClientTest.php

        $client = $this->client($profile);
        $faker = $this->getFaker();
        $username = $faker->userName;
        $password = $faker->password;

        $mock = new MockHandler([ new Response() ]);

        $client
            ->withOption('handler', $mock)
            ->useDigestAuth($username, $password)
            ->get('/get');

        $options = $mock->getLastOptions();
        $this->assertSame([
            CURLOPT_HTTPAUTH => 2,
            CURLOPT_USERPWD => $username . ':' . $password
        ], $options['curl']);
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
