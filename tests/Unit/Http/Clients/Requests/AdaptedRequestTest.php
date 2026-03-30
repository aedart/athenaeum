<?php

namespace Aedart\Tests\Unit\Http\Clients\Requests;

use Aedart\Contracts\Http\Clients\Requests\HasDriverOptions;
use Aedart\Http\Clients\Requests\AdaptedRequest;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * AdaptedRequestTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Http\Clients\Requests
 */
#[Group(
    'http-clients',
    'adapted-request',
    'psr-7',
)]
class AdaptedRequestTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new Adapted Request
     *
     * @param string                               $method  HTTP method
     * @param string|UriInterface                  $uri     URI
     * @param array                                $headers [optional] Request headers
     * @param array $driverOptions [optional]
     * @param string|null|resource|StreamInterface $body [optional] body
     * @param string                               $version [optional] version
     *
     * @return RequestInterface|HasDriverOptions
     */
    public function makeRequest(
        string $method,
        $uri,
        array $headers = [],
        array $driverOptions = [],
        $body = null,
        $version = '1.1'
    ) {
        return new AdaptedRequest(
            new Request($method, $uri, $headers, $body, $version),
            $driverOptions
        );
    }

    /*****************************************************************
     * Actual Test
     ****************************************************************/

    #[Test]
    public function canObtainDriverOptions()
    {
        $options = ['a', 'b', 'c'];

        $request = $this->makeRequest('get', '/users', [], $options);

        $this->assertSame($options, $request->getDriverOptions());
    }

    #[Test]
    public function canSetAndObtainProtocolVersion()
    {
        $version = '2.0';

        $request = $this
            ->makeRequest('get', '/users')
            ->withProtocolVersion($version);

        $this->assertInstanceOf(AdaptedRequest::class, $request);
        $this->assertSame($version, $request->getProtocolVersion());
    }

    #[Test]
    public function canSetAndObtainHeaders()
    {
        $request = $this
            ->makeRequest('get', '/users', [
                'Content-Type' => 'application/json'
            ])
            ->withHeader('Accept', 'application/xml')
            ->withAddedHeader('X-Foo', 'bar');

        $this->assertInstanceOf(AdaptedRequest::class, $request);

        $this->assertTrue($request->hasHeader('Accept'), 'Accept header not set');
        $this->assertTrue($request->hasHeader('Content-Type'), 'Content-Type header not set');

        $this->assertSame('application/json', $request->getHeader('Content-Type')[0], 'incorrect content-type');
        $this->assertSame('application/xml', $request->getHeaderLine('Accept'), 'incorrect accept');

        $this->assertSame([
            'Content-Type' => [ 'application/json' ],
            'Accept' => [ 'application/xml' ],
            'X-Foo' => [ 'bar' ],
        ], $request->getHeaders(), 'Incorrect headers');
    }

    #[Test]
    public function canRemoveHeader()
    {
        $request = $this
            ->makeRequest('get', '/users', [
                'Content-Type' => 'application/json',
                'X-Foo' => 'jam'
            ])
            ->withoutHeader('X-Foo');

        $this->assertInstanceOf(AdaptedRequest::class, $request);

        $this->assertSame([
            'Content-Type' => [ 'application/json' ],
        ], $request->getHeaders(), 'Incorrect headers');
    }

    #[Test]
    public function canSetAndObtainBody()
    {
        $stream = new Stream(fopen('php://memory', 'r+'));
        $stream->write('Foo');
        $stream->rewind();

        $request = $this
            ->makeRequest('post', '/users')
            ->withBody($stream);

        $this->assertInstanceOf(AdaptedRequest::class, $request);

        $content = $request->getBody()->getContents();
        $this->assertSame('Foo', $content);
    }

    #[Test]
    public function canSetAndObtainRequestTarget()
    {
        $target = 'https://acme.org';

        $request = $this
            ->makeRequest('post', '/users')
            ->withRequestTarget($target);

        $this->assertInstanceOf(AdaptedRequest::class, $request);

        $this->assertSame($target, $request->getRequestTarget());
    }

    #[Test]
    public function canSetAndGetHttpMethod()
    {
        $request = $this
            ->makeRequest('post', '/users')
            ->withMethod('patch');

        $this->assertInstanceOf(AdaptedRequest::class, $request);

        $this->assertSame('PATCH', $request->getMethod());
    }

    #[Test]
    public function canSetAndObtainUri()
    {
        $uri = new Uri('/users/relations/notes');

        $request = $this
            ->makeRequest('post', '/users')
            ->withUri($uri);

        $this->assertInstanceOf(AdaptedRequest::class, $request);

        $this->assertSame($uri, $request->getUri());
    }
}
