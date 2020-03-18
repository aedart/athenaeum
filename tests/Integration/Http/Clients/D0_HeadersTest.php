<?php


namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * B0_HeadersTest
 *
 * @group http-clients
 * @group http-clients-d0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class D0_HeadersTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
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
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
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
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canRemoveHeaderBeforeRequest(string $profile)
    {
        $client = $this->client($profile);

        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withHeader('X-Foo', 'bar')
            ->withoutHeader('X-Foo')
            ->request('get', '/users');

        $headerFromSent = $this->lastRequest->getHeader('X-Foo');
        $this->assertEmpty($headerFromSent, 'Specific header still sent via request');
    }
}
