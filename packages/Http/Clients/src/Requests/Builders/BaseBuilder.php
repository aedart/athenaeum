<?php

namespace Aedart\Http\Clients\Requests\Builders;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Http\Clients\Exceptions\InvalidUri;
use Aedart\Http\Clients\Traits\HttpClientTrait;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Http Request Base Builder
 *
 * Abstraction for Http Request Builders.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders
 */
abstract class BaseBuilder implements Builder
{
    use HttpClientTrait;

    /**
     * Driver specific options for the next request
     *
     * @var array
     */
    protected array $options = [];

    /**
     * The data format to use
     *
     * @var string
     */
    protected string $dataFormat = 'body';

    /**
     * The Http Headers to send
     *
     * @var array
     */
    protected array $headers = [];

    /**
     * The http method to use
     *
     * @var string
     */
    protected string $method = 'GET';

    /**
     * The Uri to send to
     *
     * @var UriInterface|null
     */
    protected ?UriInterface $uri;

    /**
     * Default Accept header for json data format
     *
     * @var string
     */
    protected string $jsonAccept = 'application/json';

    /**
     * Default Content-Type header for json data format
     *
     * @var string
     */
    protected string $jsonContentType = 'application/json';

    /**
     * BaseBuilder constructor.
     *
     * @param Client $client
     * @param array $options [optional] Driver specific options
     */
    public function __construct(Client $client, array $options = [])
    {
        $this->setHttpClient($client);

        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function get($uri = null): ResponseInterface
    {
        return $this->request('GET', $uri);
    }

    /**
     * {@inheritdoc}
     */
    public function head($uri = null): ResponseInterface
    {
        return $this->request('HEAD', $uri);
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri = null, array $body = []): ResponseInterface
    {
        return $this->request('POST', $uri, [
            $this->getDataFormat() => $body
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function put($uri = null, array $body = []): ResponseInterface
    {
        return $this->request('PUT', $uri, [
            $this->getDataFormat() => $body
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uri = null, array $body = []): ResponseInterface
    {
        return $this->request('DELETE', $uri, [
            $this->getDataFormat() => $body
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function options($uri = null): ResponseInterface
    {
        return $this->request('OPTIONS', $uri);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($uri = null, array $body = []): ResponseInterface
    {
        return $this->request('PATCH', $uri, [
            $this->getDataFormat() => $body
        ]);
    }

    /**
     * @inheritdoc
     */
    public function withMethod(string $method): Builder
    {
        $this->method = strtoupper(trim($method));

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @inheritdoc
     */
    public function withUri($uri): Builder
    {
        if(is_string($uri)){
            $uri = new Uri($uri);
        }

        if( ! ($uri instanceof UriInterface)){
            throw new InvalidUri('Provided Uri must either be a string or Psr-7 UriInterface');
        }

        $this->uri;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUri(): ?UriInterface
    {
        return $this->uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withHeaders(array $headers = []): Builder
    {
        $this->headers = array_merge_recursive($this->headers, $headers);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function withHeader(string $name, $value): Builder
    {
        return $this->withHeaders([ $name => $value ]);
    }

    /**
     * {@inheritdoc}
     */
    public function withoutHeader(string $name): Builder
    {
        $headers = $this->headers;

        $name = $this->normaliseHeaderName($name);

        $names = array_keys($headers);
        foreach ($names as $header) {
            if ($this->normaliseHeaderName($header) === $name) {
                unset($this->headers[$header]);
                break;
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader(string $name)
    {
        $headers = $this->headers;

        $name = $this->normaliseHeaderName($name);
        foreach ($headers as $header => $value) {
            if ($this->normaliseHeaderName($header) === $name) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function withAccept(string $contentType): Builder
    {
        return $this->withHeader('Accept', $contentType);
    }

    /**
     * @inheritDoc
     */
    public function withContentType(string $contentType): Builder
    {
        return $this->withHeader('Content-Type', $contentType);
    }

    /**
     * @inheritDoc
     */
    public function useDataFormat(string $format): Builder
    {
        $this->dataFormat = $format;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDataFormat(): string
    {
        return $this->dataFormat;
    }

    /**
     * @inheritDoc
     */
    public function useTokenAuth(string $token, string $scheme = 'Bearer'): Builder
    {
        return $this->withHeader('Authorization', trim($scheme . ' ' . $token));
    }

    /**
     * {@inheritdoc}
     */
    public function withOptions(array $options = []): Builder
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function withOption(string $name, $value): Builder
    {
        return $this->withOptions([ $name => $value ]);
    }

    /**
     * {@inheritdoc}
     */
    public function withoutOption(string $name): Builder
    {
        unset($this->options[$name]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function getOption(string $name)
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function client(): Client
    {
        return $this->getHttpClient();
    }

    /**
     * @inheritDoc
     *
     * @return mixed
     */
    public function driver()
    {
        return $this->client()->driver();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Prepares the options
     *
     * @param array $options [optional]
     *
     * @return array
     */
    protected function prepareOptions(array $options = []): array
    {
        return array_merge($this->options, $options);
    }

    /**
     * Normalises the header name
     *
     * @param string $name
     *
     * @return string
     */
    protected function normaliseHeaderName(string $name): string
    {
        return strtolower(trim($name));
    }
}