<?php

namespace Aedart\Http\Clients\Requests\Builders;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Guzzle Http Request Builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders
 */
class GuzzleRequestBuilder extends BaseBuilder
{
    /**
     * @inheritDoc
     */
    public function createRequest(string $method, $uri): RequestInterface
    {
        // TODO: Implement createRequest() method.
    }

    /**
     * @inheritDoc
     */
    public function get($uri): ResponseInterface
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function head($uri): ResponseInterface
    {
        // TODO: Implement head() method.
    }

    /**
     * @inheritDoc
     */
    public function post($uri, array $body = []): ResponseInterface
    {
        // TODO: Implement post() method.
    }

    /**
     * @inheritDoc
     */
    public function put($uri, array $body = []): ResponseInterface
    {
        // TODO: Implement put() method.
    }

    /**
     * @inheritDoc
     */
    public function delete($uri, array $body = []): ResponseInterface
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritDoc
     */
    public function options($uri): ResponseInterface
    {
        // TODO: Implement options() method.
    }

    /**
     * @inheritDoc
     */
    public function patch($uri, array $body = []): ResponseInterface
    {
        // TODO: Implement patch() method.
    }

    /**
     * @inheritDoc
     */
    public function request(string $method, $uri, array $options = []): ResponseInterface
    {
        // TODO: Implement request() method.
    }

    /**
     * @inheritDoc
     */
    public function withHeaders(array $headers = []): Builder
    {
        // TODO: Implement withHeaders() method.
    }

    /**
     * @inheritDoc
     */
    public function withHeader(string $name, $value): Builder
    {
        // TODO: Implement withHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader(string $name): Builder
    {
        // TODO: Implement withoutHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        // TODO: Implement getHeaders() method.
    }

    /**
     * @inheritDoc
     */
    public function getHeader(string $name)
    {
        // TODO: Implement getHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function withAccept(string $contentType): Builder
    {
        // TODO: Implement withAccept() method.
    }

    /**
     * @inheritDoc
     */
    public function withContentType(string $contentType): Builder
    {
        // TODO: Implement withContentType() method.
    }

    /**
     * @inheritDoc
     */
    public function formFormat(): Builder
    {
        // TODO: Implement formFormat() method.
    }

    /**
     * @inheritDoc
     */
    public function jsonFormat(): Builder
    {
        // TODO: Implement jsonFormat() method.
    }

    /**
     * @inheritDoc
     */
    public function multipartFormat(): Builder
    {
        // TODO: Implement multipartFormat() method.
    }

    /**
     * @inheritDoc
     */
    public function useDataFormat(string $format): Builder
    {
        // TODO: Implement useDataFormat() method.
    }

    /**
     * @inheritDoc
     */
    public function getDataFormat(): string
    {
        // TODO: Implement getDataFormat() method.
    }

    /**
     * @inheritDoc
     */
    public function useBasicAuth(string $username, string $password): Builder
    {
        // TODO: Implement useBasicAuth() method.
    }

    /**
     * @inheritDoc
     */
    public function useDigestAuth(string $username, string $password): Builder
    {
        // TODO: Implement useDigestAuth() method.
    }

    /**
     * @inheritDoc
     */
    public function useTokenAuth(string $token, string $scheme = 'Bearer'): Builder
    {
        // TODO: Implement useTokenAuth() method.
    }

    /**
     * @inheritDoc
     */
    public function maxRedirects(int $amount): Builder
    {
        // TODO: Implement maxRedirects() method.
    }

    /**
     * @inheritDoc
     */
    public function disableRedirects(): Builder
    {
        // TODO: Implement disableRedirects() method.
    }

    /**
     * @inheritDoc
     */
    public function withTimeout(float $seconds): Builder
    {
        // TODO: Implement withTimeout() method.
    }

    /**
     * @inheritDoc
     */
    public function getTimeout(): float
    {
        // TODO: Implement getTimeout() method.
    }

    /**
     * @inheritDoc
     */
    public function withOptions(array $options = []): Builder
    {
        // TODO: Implement withOptions() method.
    }

    /**
     * @inheritDoc
     */
    public function withOption(string $name, $value): Builder
    {
        // TODO: Implement withOption() method.
    }

    /**
     * @inheritDoc
     */
    public function withoutOption(string $name): Builder
    {
        // TODO: Implement withoutOption() method.
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): array
    {
        // TODO: Implement getOptions() method.
    }

    /**
     * @inheritDoc
     */
    public function getOption(string $name)
    {
        // TODO: Implement getOption() method.
    }

    /**
     * @inheritDoc
     *
     * @return GuzzleClient
     */
    public function driver()
    {
        return $this->client()->driver();
    }
}