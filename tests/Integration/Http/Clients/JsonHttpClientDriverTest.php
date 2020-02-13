<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use GuzzleHttp\Psr7\Response;

/**
 * JsonHttpClientDriverTest
 *
 * @group http
 * @group http-clients
 * @group json-http-client
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class JsonHttpClientDriverTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    public function getDefaultHttpClient(): ?Client
    {
        return $this->getHttpClientsManager()->profile('json');
    }

    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * @return array
     */
    public function httpMethods()
    {
        return [
            'GET'        => [ 'get' ],
            'POST'       => [ 'post' ],
            'PUT'        => [ 'put' ],
            'DELETE'     => [ 'delete' ],
            'PATCH'      => [ 'patch' ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider httpMethods
     *
     * @param string $method
     */
    public function setsJsonContentType(string $method)
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [ 'X-Foo' => 'Bar' ])
        ]);

        $client = $this->getHttpClient();
        $client
            ->withOption('handler', $mockedResponses)
            ->$method('/my-api');

        $headers = $this->lastRequest->getHeaders();

        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
    }

    /**
     * @test
     * @dataProvider httpMethods
     *
     * @param string $method
     */
    public function setsJsonAcceptHeader(string $method)
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [ 'X-Foo' => 'Bar' ])
        ]);

        $client = $this->getHttpClient();
        $client
            ->withOption('handler', $mockedResponses)
            ->$method('/my-api');

        $headers = $this->lastRequest->getHeaders();

        $this->assertArrayHasKey('Accept', $headers);
        $this->assertSame('application/json', $headers['Accept'][0]);
    }

    /**
     * @test
     */
    public function maintainsDefaultHeadersAfterRequest()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [ 'X-Foo' => 'Bar' ])
        ]);

        $client = $this->getHttpClient();
        $client
            ->withOption('handler', $mockedResponses)
            ->post('/my-api');

        // Obtain headers
        $accept = $client->getHeader('accept');
        $contentType = $client->getHeader('Content-TYPE');

        $this->assertSame('application/json', $accept, 'Accept header not set for next request');
        $this->assertSame('application/json', $contentType, 'Content-Type header not set for next request');
    }

    /**
     * @test
     */
    public function requestIsJsonEncoded()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [ 'X-Foo' => 'Bar' ])
        ]);

        $client = $this->getHttpClient();

        $body = [
            'name' => 'Jimmy Rick Jr.'
        ];

        $client
            ->withOption('handler', $mockedResponses)
            ->post('/v1/some-api', $body);

        $content = $this->lastRequest->getBody()->getContents();
        ConsoleDebugger::output($content);

        $this->assertJson($content);
    }
}
