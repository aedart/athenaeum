<?php


namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;

/**
 * B0_HeadersTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-d0',
)]
class D0_HeadersTest extends HttpClientsTestCase
{
    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function extractsHeadersFromOptions(string $profile)
    {
        $agent = 'Aedart/HttpClient/2.0';

        $client = $this->client($profile, [
            'headers' => [
                'User-Agent' => $agent
            ]
        ]);

        $this->assertNotEmpty($client->getHeaders(), 'Header not extracted by request builder');
        $this->assertSame($agent, $client->getHeader('User-Agent'), 'Specific header not available');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function setsHeadersForRequest(string $profile)
    {
        $client = $this->client($profile);

        $agent = 'Aedart/HttpClient/2.0';

        /** @var ResponseInterface $response */
        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withHeader('User-Agent', $agent)
            ->request('get', '/users');

        $headerFromSent = $this->lastRequest->getHeader('User-Agent')[0];
        $this->assertSame($agent, $headerFromSent, 'Specific header not set on request');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canSpecifyMultipleHeaders(string $profile)
    {
        $client = $this->client($profile);

        $value = 'Yuck, shiny shore. go to cabo rojo.';
        $builder = $client
            ->withHeaders([
                'x-token' => $value,
                'y-token' => $value
            ])
            ->withHeader('z-token', $value);

        $this->assertSame($value, $builder->getHeader('x-token'));
        $this->assertSame($value, $builder->getHeader('y-token'));
        $this->assertSame($value, $builder->getHeader('z-token'));
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canRemoveHeaderBeforeRequest(string $profile)
    {
        $client = $this->client($profile, [
            'headers' => [
                'X-Foo' => 'bar'
            ]
        ]);

        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withoutHeader('X-Foo')
            ->request('get', '/users');

        $headerFromSent = $this->lastRequest->getHeader('X-Foo');
        $this->assertEmpty($headerFromSent, 'Specific header still sent via request');
    }
}
