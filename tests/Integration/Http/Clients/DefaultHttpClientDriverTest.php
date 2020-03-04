<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

/**
 * DefaultHttpClientDriverTest
 *
 * @group http
 * @group http-clients
 * @group default-http-client
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class DefaultHttpClientDriverTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    public function getDefaultHttpClient(): ?Client
    {
        return $this->getHttpClientsManager()->profile();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    public function hasInitialOptions()
    {
        $options = $this->getHttpClient()->getOption('headers');

        ConsoleDebugger::output($options);

        $this->assertArrayHasKey('User-Agent', $options);
        $this->assertSame('Aedart/HttpClient/1.0', $options['User-Agent']);
    }

    /**
     * @test
     */
    public function canPerformGetRequest()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [ 'X-Foo' => 'Bar' ])
        ]);

        $client = $this->getHttpClient();

        $response = $client
                        ->withOption('handler', $mockedResponses)
                        ->get('/get');

        $headers = $response->getHeaders();
        ConsoleDebugger::output($headers);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertArrayHasKey('X-Foo', $headers);
        $this->assertSame('Bar', $headers['X-Foo'][0]);
    }

    /**
     * @test
     */
    public function canPerformHeadRequest()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [ 'X-Foo' => 'Bar' ])
        ]);

        $client = $this->getHttpClient();

        $response = $client
            ->withOption('handler', $mockedResponses)
            ->head('/head');

        $headers = $response->getHeaders();
        ConsoleDebugger::output($headers);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertArrayHasKey('X-Foo', $headers);
        $this->assertSame('Bar', $headers['X-Foo'][0]);
    }

    /**
     * @test
     */
    public function canPerformPostRequest()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(201, [], 'created')
        ]);

        $client = $this->getHttpClient();

        $response = $client
            ->withOption('handler', $mockedResponses)
            ->post('/post', [ 'name' => 'John Doe' ]);

        $content = $response->getBody()->getContents();
        ConsoleDebugger::output($content);

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame('created', $content);
    }

    /**
     * @test
     */
    public function canPerformPutRequest()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [], 'updated')
        ]);

        $client = $this->getHttpClient();

        $response = $client
            ->withOption('handler', $mockedResponses)
            ->put('/put', [ 'name' => 'John Doe' ]);

        $content = $response->getBody()->getContents();
        ConsoleDebugger::output($content);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('updated', $content);
    }

    /**
     * @test
     */
    public function canPerformDeleteRequest()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [], 'deleted')
        ]);

        $client = $this->getHttpClient();

        $response = $client
            ->withOption('handler', $mockedResponses)
            ->delete('/delete', [ 'name' => 'John Doe' ]);

        $content = $response->getBody()->getContents();
        ConsoleDebugger::output($content);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('deleted', $content);
    }

    /**
     * @test
     */
    public function canPerformOptionsRequest()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [ 'X-Foo' => 'Bar' ])
        ]);

        $client = $this->getHttpClient();

        $response = $client
            ->withOption('handler', $mockedResponses)
            ->options('/options');

        $headers = $response->getHeaders();
        ConsoleDebugger::output($headers);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertArrayHasKey('X-Foo', $headers);
        $this->assertSame('Bar', $headers['X-Foo'][0]);
    }

    /**
     * @test
     */
    public function canPerformPatchRequest()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [], 'patched')
        ]);

        $client = $this->getHttpClient();

        $response = $client
            ->withOption('handler', $mockedResponses)
            ->delete('/delete', [ 'name' => 'John Doe' ]);

        $content = $response->getBody()->getContents();
        ConsoleDebugger::output($content);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('patched', $content);
    }

    /**
     * @test
     */
    public function customOptionsAreResetOnNextRequest()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [], 'ok'),
            new Response(200, [], 'another ok'),
        ]);

        $client = $this->getHttpClient();

        $client
            ->withOption('handler', $mockedResponses)
            ->request('GET', '/customer-options', [
                'headers' => [ 'X-Custom' => 'my-custom-header' ]
            ]);

        $headers = $this->lastRequest->getHeaders();
        //ConsoleDebugger::output($headers);

        $this->assertArrayHasKey('X-Custom', $headers);
        $this->assertSame('my-custom-header', $headers['X-Custom'][0]);

        // ----------------------------------------------------------------------- //

        $client
            ->withOption('handler', $mockedResponses)
            ->request('GET', '/customer-options');

        $headers = $this->lastRequest->getHeaders();
        //ConsoleDebugger::output($headers);

        $this->assertArrayNotHasKey('X-Custom', $headers);
    }

    /**
     * @test
     */
    public function canSpecifyCustomHeaders()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [ 'X-Foo' => 'Bar' ])
        ]);

        $client = $this->getHttpClient();

        $client
            ->withOption('handler', $mockedResponses)
            ->withHeader('X-Wing', 27000)
            ->get('/get');

        $headers = $this->lastRequest->getHeaders();
        ConsoleDebugger::output($headers);

        $this->assertArrayHasKey('X-Wing', $headers);
        $this->assertSame('27000', $headers['X-Wing'][0]);
    }

    /**
     * @test
     */
    public function canObtainCustomHeaders()
    {
        $client = $this->getHttpClient();

        $value = 'Yuck, shiny shore. go to cabo rojo.';
        $client->withHeader('x-token', $value);

        $this->assertSame($value, $client->getHeader('x-token'));
    }

    /**
     * @test
     */
    public function canSpecifyMultipleHeaders()
    {
        $client = $this->getHttpClient();

        $value = 'Yuck, shiny shore. go to cabo rojo.';
        $client->withHeaders([
            'x-token' => $value,
            'y-token' => $value
        ])
        ->withHeader('z-token', $value);

        $this->assertSame($value, $client->getHeader('x-token'));
        $this->assertSame($value, $client->getHeader('y-token'));
        $this->assertSame($value, $client->getHeader('z-token'));
    }

    /**
     * @test
     */
    public function canObtainDriver()
    {
        $client = $this->getHttpClient();

        $this->assertNotNull($client->driver());
    }

    /**
     * @test
     */
    public function canObtainContentFromGoogle()
    {
        // "live" integration test to see if guzzle works
        // as intended.

        $client = $this->getHttpClient();

        $response = $client
            ->withoutHeader('User-Agent') // Default to Guzzle's default User-Agent header
            ->get('https://google.com');

        $content = $response->getBody()->getContents();
        ConsoleDebugger::output($content);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertNotEmpty($content);
    }

    /**
     * @test
     */
    public function sendsBasicAuthHeader()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [ 'X-Foo' => 'Bar' ])
        ]);

        $client = $this->getHttpClient();

        $faker = $this->getFaker();
        $username = $faker->userName;
        $password = $faker->password;

        $client
            ->withOption('handler', $mockedResponses)
            ->useBasicAuth($username, $password)
            ->get('/get');

        $headers = $this->lastRequest->getHeaders();
        ConsoleDebugger::output($headers);

        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertStringContainsString('Basic', $headers['Authorization'][0]);
    }

    /**
     * @test
     */
    public function sendsDigestAuthHeader()
    {
        $mock = new MockHandler([new Response()]);

        $client = $this->getHttpClient();

        $faker = $this->getFaker();
        $username = $faker->userName;
        $password = $faker->password;

        $client
            ->withOption('handler', $mock)
            ->useDigestAuth($username, $password)
            ->get('/get');

        //$headers = $this->lastRequest->getHeaders();

        // Test inspired by Guzzle's own way of testing this.
        $lastOptions = $mock->getLastOptions();

        ConsoleDebugger::output($lastOptions['curl']);

        $this->assertSame([
            CURLOPT_HTTPAUTH => 2,
            CURLOPT_USERPWD => $username . ':' . $password
        ], $lastOptions['curl']);
    }

    /**
     * @test
     */
    public function sendsTokenAuthHeader()
    {
        $mockedResponses = $this->makeResponseMock([
            new Response(200, [ 'X-Foo' => 'Bar' ])
        ]);

        $client = $this->getHttpClient();

        $faker = $this->getFaker();
        $token = sha1($faker->password);

        $client
            ->withOption('handler', $mockedResponses)
            ->useTokenAuth($token)
            ->get('/get');

        $headers = $this->lastRequest->getHeaders();
        ConsoleDebugger::output($headers);

        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertStringContainsString('Bearer', $headers['Authorization'][0]);
        $this->assertStringContainsString($token, $headers['Authorization'][0]);
    }

    /**
     * @test
     */
    public function hasHttpErrorsDisabledByDefault()
    {
        $client = $this->getHttpClient();

        $result = $client->getOption('http_errors');

        $this->assertFalse($result, 'Http errors SHOULD be set to false');
    }

    /**
     * @test
     */
    public function hasConnectTimeoutSetByDefault()
    {
        $client = $this->getHttpClient();

        $result = $client->getOption('connect_timeout');

        $this->assertGreaterThan(0, $result, 'Connection Timeout SHOULD be set!');
    }

    /**
     * @test
     */
    public function hasRequestTimeoutSetByDefault()
    {
        $client = $this->getHttpClient();

        $result = $client->getOption('timeout');

        $this->assertGreaterThan(0, $result, 'Timeout SHOULD be set!');
    }

    /**
     * @test
     */
    public function canSpecifyTimeout()
    {
        $client = $this->getHttpClient();

        $seconds = (float) $this->getFaker()->randomDigitNotNull;

        $result = $client
            ->withTimeout($seconds)
            ->getTimeout();

        $this->assertSame($seconds, $result, 'Request timeout incorrect');
    }

    /**
     * @test
     */
    public function hasFollowRedirectsSetByDefault()
    {
        $client = $this->getHttpClient();

        $result = $client->getOption('allow_redirects');

        ConsoleDebugger::output($result);

        $this->assertSame(1, $result['max'], 'Max amount of redirects is incorrect');
        $this->assertSame(true, $result['strict'], 'Should be strict redirects');
        $this->assertSame(true, $result['referer'], 'Should have referer set to true');
        $this->assertSame(['http', 'https'], $result['protocols'], 'Incorrect protocols');
        $this->assertSame(false, $result['track_redirects'], 'Should not track redirects');
    }

    /**
     * @test
     */
    public function canDisableRedirectBehaviour()
    {
        $client = $this->getHttpClient();

        $client->maxRedirects(0);

        $result = $client->getOption('allow_redirects');

        $this->assertFalse($result, 'Allow redirects should be disabled');
    }

    /**
     * @test
     */
    public function canSpecifyMaxRedirects()
    {
        $client = $this->getHttpClient();

        $client->maxRedirects(5);

        $result = $client->getOption('allow_redirects');

        ConsoleDebugger::output($result);

        $this->assertSame(5, $result['max'], 'Max amount of redirects is incorrect');
    }
}
