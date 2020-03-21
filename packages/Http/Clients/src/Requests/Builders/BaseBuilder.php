<?php

namespace Aedart\Http\Clients\Requests\Builders;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Attachment;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Cookies\Cookie;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Aedart\Http\Clients\Exceptions\InvalidAttachmentFormat;
use Aedart\Http\Clients\Exceptions\InvalidCookieFormat;
use Aedart\Http\Clients\Exceptions\InvalidUri;
use Aedart\Http\Clients\Requests\Attachment as RequestAttachment;
use Aedart\Http\Clients\Traits\HttpClientTrait;
use Aedart\Http\Cookies\SetCookie;
use Aedart\Support\Helpers\Container\ContainerTrait;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use Illuminate\Contracts\Pipeline\Pipeline as PipelineInterface;
use Illuminate\Pipeline\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

use function GuzzleHttp\Psr7\parse_query;

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
     * Default attachment name given, when no name provided
     */
    protected const NO_ATTACHMENT_NAME = '@:_no_att_name_:@';

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
     * Base Url for next request
     *
     * @var string
     */
    protected string $baseUrl = '';

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
     * Http query string values
     *
     * @var array Key-value pairs
     */
    protected array $query = [];

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
     * Attachments
     *
     * @var Attachment[] Key = form input name, value = attachment instance
     */
    protected array $attachments = [];

    /**
     * Cookies
     *
     * @var Cookie[] Key = cookie name, value = cookie instance
     */
    protected array $cookies = [];

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
    public function withBaseUrl(string $url): Builder
    {
        $this->baseUrl = $url;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasBaseUrl(): bool
    {
        return !empty($this->baseUrl);
    }

    /**
     * @inheritdoc
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @inheritdoc
     */
    public function withUri($uri): Builder
    {
        // Build a new query, if a string uri has been provided.
        if (is_string($uri)) {
            $uri = new Uri($uri);
        }

        // Abort if uri wasn't a string or Psr-7 Uri.
        if (!($uri instanceof UriInterface)) {
            throw new InvalidUri('Provided Uri must either be a string or Psr-7 UriInterface');
        }

        // Extract http query, if uri contains such and apply
        // it onto this builder.
        $this->withQuery(
            $this->extractQueryFromUri($uri)
        );

        // Remove the http query on the uri instance, so that it
        // does not cause issues when the request is performed.
        $this->uri = $uri->withQuery('');

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
     * @inheritdoc
     */
    public function from($uri): Builder
    {
        return $this->withUri($uri);
    }

    /**
     * @inheritdoc
     */
    public function into($uri): Builder
    {
        return $this->withUri($uri);
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
        $name = $this->normaliseHeaderName($name);

        $names = array_keys($this->headers);
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
        $name = $this->normaliseHeaderName($name);
        foreach ($this->headers as $header => $value) {
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
        return $this
            ->withoutHeader('Accept')
            ->withHeader('Accept', $contentType);
    }

    /**
     * @inheritDoc
     */
    public function withContentType(string $contentType): Builder
    {
        return $this
            ->withoutHeader('Content-Type')
            ->withHeader('Content-Type', $contentType);
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
        return $this
            ->withoutHeader('Authorization')
            ->withHeader('Authorization', trim($scheme . ' ' . $token));
    }

    /**
     * @inheritdoc
     */
    public function withQuery(array $query): Builder
    {
        return $this->setQuery(
            array_merge($this->getQuery(), $query)
        );
    }

    /**
     * @inheritdoc
     */
    public function setQuery(array $query): Builder
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasQuery(): bool
    {
        return !empty($this->query);
    }

    /**
     * @inheritdoc
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @inheritdoc
     */
    public function where($field, $type = null, $value = null): Builder
    {
        // When list of fields => values is given.
        if (is_array($field)) {
            return $this->addQueryFieldsWithValues($field);
        }

        // Prepare the value to be used. We assume that only two arguments are
        // provided, at this point. This means that the "type" argument acts as
        // the field's value.
        $appliedValue = $type;

        // When all arguments are provided, then we change the structure of the
        // applied value, to match that of "Sparse Fieldset", as described by
        // Json Api v1.x.
        if (func_num_args() === 3) {
            $appliedValue = [ $type => $value ];
        }

        // Prepare the "query" field and value to be added.
        $query = [ $field => $appliedValue];

        // Merge the query recursively, with the existing query values.
        // This allows multiple calls to the same field to be performed.
        return $this->setQuery(
            array_merge_recursive($this->getQuery(), $query)
        );
    }

    /**
     * @inheritdoc
     */
    public function when(bool $result, callable $callback, ?callable $otherwise = null): Builder
    {
        if ($result === true) {
            $callback($this);
        } elseif (isset($otherwise)) {
            $otherwise($this);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function unless(bool $result, callable $callback, ?callable $otherwise = null): Builder
    {
        return $this->when(!$result, $callback, $otherwise);
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
    public function hasData(): bool
    {
        return !empty($this->data);
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
    public function withRawPayload($body): Builder
    {
        $this->rawPayload = $body;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRawPayload()
    {
        return $this->rawPayload;
    }

    /**
     * @inheritdoc
     */
    public function hasRawPayload(): bool
    {
        return !empty($this->rawPayload);
    }

    /**
     * @inheritdoc
     */
    public function withAttachment($attachment): Builder
    {
        $this->multipartFormat();

        if (is_array($attachment)) {
            $attachment = $this->makeAttachment($attachment);
        }

        if (is_callable($attachment)) {
            $attachment = $this->resolveCallbackAttachment($attachment);
        }

        if (!($attachment instanceof Attachment)) {
            throw new InvalidAttachmentFormat('Argument must be an Attachment instance, array, or callback');
        }

        // Add to list of attachments
        $this->attachments[$attachment->getName()] = $attachment;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withAttachments(array $attachments = []): Builder
    {
        foreach ($attachments as $attachment) {
            $this->withAttachment($attachment);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withoutAttachment(string $name): Builder
    {
        unset($this->attachments[$name]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasAttachment(string $name): bool
    {
        return isset($this->attachments[$name]);
    }

    /**
     * @inheritdoc
     */
    public function getAttachment(string $name): ?Attachment
    {
        if ($this->hasAttachment($name)) {
            return $this->attachments[$name];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getAttachments(): array
    {
        return array_values($this->attachments);
    }

    /**
     * @inheritdoc
     */
    public function attachFile(
        string $name,
        string $path,
        array $headers = [],
        ?string $filename = null
    ): Builder {
        $attachment = $this->makeAttachment([
            'name' => $name,
            'headers' => $headers,
            'filename' => $filename
        ])->attachFile($path);

        return $this->withAttachment($attachment);
    }

    /**
     * @inheritdoc
     */
    public function withCookie($cookie): Builder
    {
        if (is_array($cookie)) {
            $cookie = $this->makeCookie($cookie);
        }

        if (is_callable($cookie)) {
            $cookie = $this->resolveCallbackCookie($cookie);
        }

        if (!($cookie instanceof Cookie)) {
            throw new InvalidCookieFormat('Argument must be a Cookie instance, array, or callback');
        }

        // Add to list of cookies
        $this->cookies[$cookie->getName()] = $cookie;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withCookies(array $cookies = []): Builder
    {
        foreach ($cookies as $cookie) {
            $this->withCookie($cookie);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withoutCookie(string $name): Builder
    {
        unset($this->cookies[$name]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasCookie(string $name): bool
    {
        return isset($this->cookies[$name]);
    }

    /**
     * @inheritdoc
     */
    public function getCookie(string $name): ?Cookie
    {
        if ($this->hasCookie($name)) {
            return $this->cookies[$name];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getCookies(): array
    {
        return array_values($this->cookies);
    }

    /**
     * @inheritdoc
     */
    public function addCookie(string $name, ?string $value = null): Builder
    {
        return $this->withCookie([ 'name' => $name, 'value' => $value ]);
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
     * Resolves an attachment from given callback
     *
     * @param callable $callback New {@see Attachment} instance is given as callback argument
     *
     * @return Attachment
     */
    protected function resolveCallbackAttachment(callable $callback): Attachment
    {
        // Create attachment
        $attachment = $this->makeAttachment();

        // Invoke callback
        $callback($attachment);

        // Finally, return attachment
        return $attachment;
    }

    /**
     * Resolves a cookie from given callback
     *
     * @param callable $callback New {@see Cookie} instance is given as callback argument
     *
     * @return Cookie
     */
    protected function resolveCallbackCookie(callable $callback): Cookie
    {
        // Create cookie
        $cookie = $this->makeCookie();

        // Invoke the callback
        $callback($cookie);

        // Finally, return cookie
        return $cookie;
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

    /**
     * Extracts the Http query fragment from given Uri
     *
     * @param UriInterface $uri
     *
     * @return array Empty if Uri does not contain a Http query
     */
    protected function extractQueryFromUri(UriInterface $uri): array
    {
        $query = $uri->getQuery();
        if (!empty($query)) {
            return parse_query($query);
        }

        return [];
    }

    /**
     * Add multiple Http query values for list of fields
     *
     * @see where
     *
     * @param array $fields
     *
     * @return self
     */
    protected function addQueryFieldsWithValues(array $fields): Builder
    {
        foreach ($fields as $field => $value) {
            $this->where($field, $value);
        }

        return $this;
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
     * Creates a new attachment instance
     *
     * @param array $data [optional]
     *
     * @return Attachment
     */
    protected function makeAttachment(array $data = []): Attachment
    {
        return new RequestAttachment($data);
    }

    /**
     * Creates a new Cookie instance
     *
     * @param array $data [optional]
     *
     * @return Cookie
     */
    protected function makeCookie(array $data = []): Cookie
    {
        // NOTE: The SetCookie inherits from Cookie. While this
        // shouldn't be used for requests, it might be useful
        // for responses, should such be required, e.g.
        // response formatting, ...etc.
        return new SetCookie($data);
    }
}
