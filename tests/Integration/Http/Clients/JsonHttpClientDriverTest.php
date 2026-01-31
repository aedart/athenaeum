<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * JsonHttpClientDriverTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-json',
)]
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
        return $this->client('json');
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
            'GET' => [ 'get' ],
            'POST' => [ 'post' ],
            'PUT' => [ 'put' ],
            'DELETE' => [ 'delete' ],
            'PATCH' => [ 'patch' ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @param string $method
     */
    #[DataProvider('httpMethods')]
    #[Test]
    public function setsJsonContentType(string $method)
    {
        $client = $this->getHttpClient();
        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->$method('/my-api');

        $headers = $this->lastRequest->getHeaders();

        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertSame('application/json', $headers['Content-Type'][0]);
    }

    /**
     * @param string $method
     */
    #[DataProvider('httpMethods')]
    #[Test]
    public function setsJsonAcceptHeader(string $method)
    {
        $client = $this->getHttpClient();
        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->$method('/my-api');

        $headers = $this->lastRequest->getHeaders();

        $this->assertArrayHasKey('Accept', $headers);
        $this->assertSame('application/json', $headers['Accept'][0]);
    }

    #[Test]
    public function maintainsDefaultHeadersAfterRequest()
    {
        $client = $this->getHttpClient()
            ->withOption('handler', $this->makeRespondsOkMock());

        $client->post('/my-api');

        // Obtain headers
        $accept = $client->getHeader('accept');
        $contentType = $client->getHeader('Content-TYPE');

        $this->assertSame('application/json', $accept, 'Accept header not set for next request');
        $this->assertSame('application/json', $contentType, 'Content-Type header not set for next request');
    }

    #[Test]
    public function requestIsJsonEncoded()
    {
        $body = [
            'name' => 'Jimmy Rick Jr.'
        ];

        $client = $this->getHttpClient()
            ->withOption('handler', $this->makeRespondsOkMock());

        $client->post('/v1/some-api', $body);

        $content = $this->lastRequest->getBody()->getContents();
        ConsoleDebugger::output($content);

        $this->assertJson($content);
    }
}
