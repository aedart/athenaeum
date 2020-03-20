<?php

namespace Aedart\Contracts\Http\Clients\Requests;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidAttachmentFormatException;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidUriException;
use Aedart\Contracts\Http\Clients\HttpClientAware;
use InvalidArgumentException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Throwable;

/**
 * Http Request Builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests
 */
interface Builder extends HttpClientAware,
    RequestFactoryInterface
{
    /**
     * Make a GET request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/GET
     *
     * @see withUri
     *
     * @param string|UriInterface|null $uri [optional] If none given, then builder's Uri is used
     *
     * @return ResponseInterface
     */
    public function get($uri = null): ResponseInterface;

    /**
     * Make a HEAD request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/HEAD
     *
     * @see withUri
     *
     * @param string|UriInterface|null $uri [optional] If none given, then builder's Uri is used
     *
     * @return ResponseInterface
     */
    public function head($uri = null): ResponseInterface;

    /**
     * Make a POST request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/POST
     *
     * @see withUri
     *
     * @param string|UriInterface|null $uri [optional] If none given, then builder's Uri is used
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function post($uri = null, array $body = []): ResponseInterface;

    /**
     * Make a PUT request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PUT
     *
     * @see withUri
     *
     * @param string|UriInterface|null $uri [optional] If none given, then builder's Uri is used
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function put($uri = null, array $body = []): ResponseInterface;

    /**
     * Make a DELETE request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/DELETE
     *
     * @see withUri
     *
     * @param string|UriInterface|null $uri [optional] If none given, then builder's Uri is used
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function delete($uri = null, array $body = []): ResponseInterface;

    /**
     * Make a OPTIONS request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/OPTIONS
     *
     * @see withUri
     *
     * @param string|UriInterface|null $uri [optional] If none given, then builder's Uri is used
     *
     * @return ResponseInterface
     */
    public function options($uri = null): ResponseInterface;

    /**
     * Make a PATCH request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PATCH
     *
     * @see withUri
     *
     * @param string|UriInterface|null $uri [optional] If none given, then builder's Uri is used
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function patch($uri = null, array $body = []): ResponseInterface;

    /**
     * Make a http request
     *
     * @see withUri
     *
     * @param string|null $method [optional] Http method name. If none given, builder's method is used
     * @param string|UriInterface|null $uri [optional] If none given, then builder's Uri is used
     * @param array $options [optional] Driver specific options. These options are merged with
     *                       builder's already set options, if any given.
     *
     * @return ResponseInterface
     */
    public function request(?string $method = null, $uri = null, array $options = []): ResponseInterface;

    /**
     * Send the given request
     *
     * @param RequestInterface $request
     * @param array $options [optional] Driver specific options.
     *                       NOTE: Builder's options are NOT applied, nor merged with given options!
     *
     * @return ResponseInterface
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface;

    /**
     * Set the Http method, for the next request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
     *
     * @param string $method
     *
     * @return self
     */
    public function withMethod(string $method): self;

    /**
     * Returns the Http method, for the next request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Set the Uri for the next request
     *
     * @param string|UriInterface $uri
     *
     * @return self
     *
     * @throws InvalidUriException If given Uri argument is invalid
     */
    public function withUri($uri): self;

    /**
     * Get Uri for the next request
     *
     * @return UriInterface|null
     */
    public function getUri(): ?UriInterface;

    /**
     * Set the Http headers for the next request
     *
     * Method will merge with existing headers, if client has any predefined
     *
     * @param array $headers [optional] Key-value pair
     *
     * @return self
     */
    public function withHeaders(array $headers = []): self;

    /**
     * Set a Http header for the next request
     *
     * Method will merge with existing headers, if client has any predefined
     *
     * @param string $name
     * @param mixed $value
     *
     * @return self
     */
    public function withHeader(string $name, $value): self;

    /**
     * Remove a Http header from the next request
     *
     * @param string $name
     *
     * @return self
     */
    public function withoutHeader(string $name): self;

    /**
     * Get all the Http headers for the next request
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Get the desired Http header, for the next request
     *
     * @param string $name Case-insensitive
     *
     * @return mixed
     */
    public function getHeader(string $name);

    /**
     * Set the HTTP protocol version, for the next request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Messages
     *
     * @param string $version
     *
     * @return self
     */
    public function useProtocolVersion(string $version): self;

    /**
     * Get the HTTP protocol version, for the next request
     *
     * @return string
     */
    public function getProtocolVersion(): string;

    /**
     * Use given Accept header for the next request
     *
     * Method remove already set Accept header, before
     * applying new value.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Accept
     *
     * @param string $contentType
     *
     * @return self
     */
    public function withAccept(string $contentType): self;

    /**
     * Use given Content-Type for the next request
     *
     * Method remove already set Content-Type header, before
     * applying new value.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Type
     *
     * @param string $contentType
     *
     * @return self
     */
    public function withContentType(string $contentType): self;

    /**
     * Use application/x-www-form-urlencoded as next request's body format.
     *
     * Method might set Accept or Content-Type headers,
     * if required.
     *
     * @see useDataFormat
     *
     * @return self
     */
    public function formFormat(): self;

    /**
     * Use json as data format as next request's body format.
     *
     * Method might set Accept or Content-Type headers,
     * if required.
     *
     * @see useDataFormat
     *
     * @return self
     */
    public function jsonFormat(): self;

    /**
     * Use multipart/form-data as next request's body format.
     *
     * Method might set Accept or Content-Type headers,
     * if required.
     *
     * @see useDataFormat
     *
     * @return self
     */
    public function multipartFormat(): self;

    /**
     * Use the given data format for the next request
     *
     * @param string $format Driver specific format identifier
     *
     * @return self
     */
    public function useDataFormat(string $format): self;

    /**
     * Get the data format to use for the next request
     *
     * @return string Driver specific format identifier
     */
    public function getDataFormat(): string;

    /**
     * Use Basic Http Authentication, for the next request
     *
     * @see https://tools.ietf.org/html/rfc7617
     *
     * @param string $username
     * @param string $password
     *
     * @return self
     */
    public function useBasicAuth(string $username, string $password): self;

    /**
     * Use Digest Authentication, for the next request
     *
     * @see https://tools.ietf.org/html/rfc7616
     *
     * @param string $username
     * @param string $password
     *
     * @return self
     */
    public function useDigestAuth(string $username, string $password): self;

    /**
     * Use a token as authentication, for the next request
     *
     * @see https://tools.ietf.org/html/rfc6750
     *
     * @param string $token
     * @param string $scheme [optional] Basic Authentication Scheme
     *
     * @return self
     */
    public function useTokenAuth(string $token, string $scheme = 'Bearer'): self;

    /**
     * Set the maximum amount of redirects to follow,
     * for the next request.
     *
     * If follow redirects was disabled and an amount
     * other than 0 is specified, then follow behaviour
     * is enabled again, for next request.
     *
     * @param int $amount If 0 given, then follow redirects is disabled.
     *
     * @return self
     */
    public function maxRedirects(int $amount): self;

    /**
     * Disables the follow redirects behaviour,
     * for the next request
     *
     * @return self
     */
    public function disableRedirects(): self;

    /**
     * Set the next request's timeout
     *
     * @param float $seconds
     *
     * @return self
     */
    public function withTimeout(float $seconds): self;

    /**
     * Get the next request's timeout
     *
     * @return float Duration in seconds
     */
    public function getTimeout(): float;

    /**
     * Add query string values to the next request
     *
     * Method merges given values with existing.
     *
     * NOTE: When this method used, evt. query string
     * applied on the Uri is ignored.
     *
     * @see setQuery
     * @see https://en.wikipedia.org/wiki/Query_string
     *
     * @param array $query Key-value pair
     *
     * @return self
     */
    public function withQuery(array $query): self;

    /**
     * Set the Http query string for the next request
     *
     * Method will overwrite existing query.
     *
     * NOTE: When this method used, evt. query string
     * applied on the Uri is ignored.
     *
     * @see https://en.wikipedia.org/wiki/Query_string
     *
     * @param array $query Key-value pair
     *
     * @return self
     */
    public function setQuery(array $query): self;

    /**
     * Determine if Http query string values have been set
     * for the next request
     *
     * @return bool
     */
    public function hasQuery(): bool;

    /**
     * Get the Http query string values for the next
     * request
     *
     * @return array Key-value pairs
     */
    public function getQuery(): array;

    /**
     * Add a Http query value, for the given field
     *
     * Method attempts to merge field values recursively, with
     * existing query values.
     *
     * When only two arguments are provided, the second argument
     * acts as the value, and the last argument is omitted.
     *
     * When all three arguments are provided, the second arguments
     * acts either as a "sparse field type" identifier, as described
     * by Json API v1.x.
     *
     * If the first argument is a list of fields with values, then
     * both `$type` and `$value` arguments are ignored.
     *
     * @see setQuery
     * @see withQuery
     * @see https://en.wikipedia.org/wiki/Query_string
     * @see https://jsonapi.org/format/#fetching-pagination
     * @see https://jsonapi.org/format/#fetching-sparse-fieldsets
     *
     * @param string|array $field Field name or List of fields with values
     * @param mixed $type [optional] Sparse fieldset identifier (string) or field value
     * @param mixed $value [optional] Field value. Only used if `$type` argument is provided
     *
     * @return self
     */
    public function where($field, $type = null, $value = null): self;

    /**
     * Add data to the next request's payload (body).
     *
     * Method will merge given data with existing payload.
     *
     * Depending on driver, method might not allow setting
     * data if a raw payload has been set.
     *
     * @see setData
     * @see getData
     *
     * @param array $data Decoded payload, key-value pairs
     *
     * @return self
     *
     * @throws Throwable
     */
    public function withData(array $data): self;

    /**
     * Set the next request's payload (body).
     *
     * Method will overwrite existing data.
     *
     * Depending on driver, method might not allow setting
     * data if a raw payload has been set.
     *
     * @see withData
     * @see getData
     *
     * @param array $data Decoded payload, key-value pairs
     *
     * @return self
     *
     * @throws Throwable
     */
    public function setData(array $data): self;

    /**
     * Determine if next request has payload data
     *
     * @return bool
     */
    public function hasData(): bool;

    /**
     * Get the next request's payload (body)
     *
     * @return array Decoded payload, key-value pairs
     */
    public function getData(): array;

    /**
     * Set the next request's raw payload (body)
     *
     * Depending on driver, method might not allow setting
     * the raw payload, if data has already been set.
     *
     * If a raw payload has already been set, invoking this
     * method will result in existing payload being
     * overwritten.
     *
     * @see getRawPayload
     * @see withData
     *
     * @param mixed $body
     *
     * @return self
     *
     * @throws Throwable
     */
    public function withRawPayload($body): self;

    /**
     * Get the next request's raw payload (body)
     *
     * If data has been set via "withData" or "setData",
     * then this method will not return anything (null).
     *
     * @see withData
     * @see withRawPayload
     *
     * @return mixed Null if raw payload not set
     */
    public function getRawPayload();

    /**
     * Determine if the next request has a raw
     * payload (body) set
     *
     * @return bool
     */
    public function hasRawPayload(): bool;

    /**
     * Add an attachment to the next request
     *
     * @param string $name Form input name
     * @param Attachment|callable $attachment If a callback is provided, a new attachment
     *                          instance will be given as the callback's argument.
     *                          If Attachment is given, then it's name is overwritten with
     *                          the form input name given to this method.
     *
     * @return self
     *
     * @throws InvalidAttachmentFormatException
     */
    public function withAttachment(string $name, $attachment): self;

    /**
     * Add one or more attachments to the next request
     *
     * @see withAttachment
     *
     * @param Attachment[]|callable[] $attachments List of attachments or callbacks.
     *                              Callbacks are given new attachment instance as argument.
     *
     * @return self
     *
     * @throws InvalidAttachmentFormatException
     */
    public function withAttachments(array $attachments = []): self;

    /**
     * Remove an attachment from the next request
     *
     * @param string $name Form input name
     *
     * @return self
     */
    public function withoutAttachment(string $name): self;

    /**
     * Determine if an attachment exists
     *
     * @param string $name Form input name
     *
     * @return bool
     */
    public function hasAttachment(string $name): bool;

    /**
     * Get the attachment with the given name
     *
     * @param string $name Form input name
     *
     * @return Attachment|null
     */
    public function getAttachment(string $name): ?Attachment;

    /**
     * Get the attachments for the next request
     *
     * @return Attachment[]
     */
    public function getAttachments(): array;

    /**
     * Attach a file to the next request
     *
     * @param string $name Form input name
     * @param string $path Path to file
     * @param array $headers [optional] Http headers for attachment
     * @param string|null $filename [optional] Filename to be used by request
     *
     * @return self
     *
     * @throws InvalidFilePathException If path to file is invalid
     * @throws InvalidAttachmentFormatException
     */
    public function attachFile(
        string $name,
        string $path,
        array $headers = [],
        ?string $filename = null
    ): self;

    /**
     * Apply a set of options for the next request
     *
     * Method will merge given options with Client's default options
     *
     * @param array $options [optional]
     *
     * @return self
     */
    public function withOptions(array $options = []): self;

    /**
     * Set a specific option for the next request
     *
     * Method will merge given options with Client's default options
     *
     * @param string $name
     * @param mixed $value
     *
     * @return self
     */
    public function withOption(string $name, $value): self;

    /**
     * Remove given option for the next request
     *
     * @param string $name
     *
     * @return self
     */
    public function withoutOption(string $name): self;

    /**
     * Get all the options for the next request
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * Get a specific option for the next request
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getOption(string $name);

    /**
     * Alias for getHttpClient
     *
     * @see getHttpClient
     *
     * @return Client
     */
    public function client(): Client;

    /**
     * Get Http Client's native driver
     *
     * @return mixed
     */
    public function driver();
}
