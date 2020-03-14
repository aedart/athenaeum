<?php

namespace Aedart\Http\Clients\Requests\Builders;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Aedart\Http\Clients\Exceptions\InvalidUri;
use Aedart\Http\Clients\Traits\HttpClientTrait;
use Aedart\Support\Helpers\Container\ContainerTrait;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use Illuminate\Contracts\Pipeline\Pipeline as PipelineInterface;
use Illuminate\Pipeline\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Throwable;

/**
 * Http Request Base Builder
 *
 * Abstraction for Http Request Builders.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders
 */
abstract class BaseBuilder implements
    Builder,
    ContainerAware
{
    use HttpClientTrait;
    use ContainerTrait;

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
    protected string $dataFormat = RequestOptions::FORM_PARAMS;

    /**
     * The Http Headers to send
     *
     * @var array
     */
    protected array $headers = [];

    /**
     * The Http protocol version
     *
     * @var string
     */
    protected string $httpProtocolVersion = '1.1';

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
     * The request payload (body)
     *
     * Might be empty, if raw payload used.
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Raw payload (body) of request.
     *
     * Might NOT be set, if data is set via
     * "withData" or "setData".
     *
     * @var mixed
     */
    protected $rawPayload;

    /**
     * BaseBuilder constructor.
     *
     * @param Client $client
     * @param array $options [optional] Driver specific options
     */
    public function __construct(Client $client, array $options = [])
    {
        $this
            ->setHttpClient($client)
            ->setContainer($client->getContainer());

        // Prepare this builder, using the following options
        $this->options = $this->prepareBuilderFromOptions($options);
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
            RequestOptions::FORM_PARAMS => $body
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function put($uri = null, array $body = []): ResponseInterface
    {
        return $this->request('PUT', $uri, [
            RequestOptions::FORM_PARAMS => $body
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uri = null, array $body = []): ResponseInterface
    {
        return $this->request('DELETE', $uri, [
            RequestOptions::FORM_PARAMS => $body
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
            RequestOptions::FORM_PARAMS => $body
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
        if (is_string($uri)) {
            $uri = new Uri($uri);
        }

        if (!($uri instanceof UriInterface)) {
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
     * @inheritdoc
     */
    public function useProtocolVersion(string $version): Builder
    {
        $this->httpProtocolVersion = $version;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getProtocolVersion(): string
    {
        return $this->httpProtocolVersion;
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
     * @inheritdoc
     */
    public function withData(array $data): Builder
    {
        return $this->setData(
            array_merge($this->getData(), $data)
        );
    }

    /**
     * @inheritdoc
     */
    public function setData(array $data): Builder
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function withRaw($body): Builder
    {
        $this->rawPayload = $body;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRaw()
    {
        return $this->rawPayload;
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
     * Prepares this builder, based on given driver specific options.
     *
     * Method MIGHT alter the resulting driver options, depending on
     * circumstance and context.
     *
     * @param array $options [optional] Driver specific options
     *
     * @return array Driver specific options
     */
    protected function prepareBuilderFromOptions(array $options = []): array
    {
        return $options;
    }

    /**
     * Processes the driver's options via given set of pipes
     *
     * Depending on the given pipes and options, both the
     * provided options as well as this builder's properties
     * and state can be mutated by the pipes.
     *
     * @see makePipeline
     * @see \Illuminate\Contracts\Pipeline\Pipeline
     *
     * @param string[] $pipes List of class paths
     * @param array $options [optional]
     *
     * @return array Processed Driver Options
     */
    protected function processDriverOptions(array $pipes, array $options = []): array
    {
        return $this
            ->makePipeline()
            ->send(new ProcessedOptions($this, $options))
            ->through($pipes)
            ->then(function (ProcessedOptions $prepared) {
                return $prepared->options();
            });
    }

    /**
     * Creates a new Pipeline instance
     *
     * @return PipelineInterface
     */
    protected function makePipeline(): PipelineInterface
    {
        return new Pipeline($this->getContainer());
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
