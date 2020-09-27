<?php

namespace Aedart\Tests\TestCases\Http;

use Aedart\Http\Messages\Providers\HttpSerializationServiceProvider;
use Aedart\Http\Messages\Traits\HttpSerializerFactoryTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Aedart\Tests\Helpers\Dummies\Http\Messages\InvalidHttpMessage;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * Http Serialization Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Http
 */
abstract class HttpSerializationTestCase extends LaravelTestCase
{
    use HttpSerializerFactoryTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            HttpSerializationServiceProvider::class
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new Http Request instance
     *
     * @param string                               $method  HTTP method
     * @param string|UriInterface                  $uri     URI
     * @param array                                $headers  [optional] Request headers
     * @param string|null|resource|StreamInterface $body  [optional] Request body
     * @param string                               $version  [optional] Protocol version
     *
     * @return RequestInterface
     */
    public function makeRequest(
        string $method,
        $uri,
        array $headers = [],
        $body = null,
        string $version = '1.1'
    ): RequestInterface {
        return new Request($method, $uri, $headers, $body, $version);
    }

    /**
     * Creates a new Http Response instance
     *
     * @param int                                  $status  [optional] Status code
     * @param array                                $headers  [optional] Response headers
     * @param string|null|resource|StreamInterface $body  [optional] Response body
     * @param string                               $version  [optional] Protocol version
     * @param string|null                          $reason  [optional] Reason phrase (when empty a default will be used based on the status code)
     *
     * @return ResponseInterface
     */
    public function makeResponse(
        int $status = 200,
        array $headers = [],
        $body = null,
        string $version = '1.1',
        ?string $reason = null
    ): ResponseInterface {
        return new Response($status, $headers, $body, $version, $reason);
    }

    /**
     * Creates an invalid Http Message instances
     *
     * @return MessageInterface
     */
    public function makeInvalidHttpMessage(): MessageInterface
    {
        return new InvalidHttpMessage();
    }
}
