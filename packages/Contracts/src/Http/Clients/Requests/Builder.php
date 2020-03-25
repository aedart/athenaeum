<?php

namespace Aedart\Contracts\Http\Clients\Requests;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidAttachmentFormatException;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidCookieFormatException;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidUriException;
use Aedart\Contracts\Http\Clients\HttpClientAware;
use Aedart\Contracts\Http\Cookies\Cookie;
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
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/GET
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getQuery} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see withQuery},
     *                                  {@see setQuery}, {@see where}, or other http query method.
     *
     * @return ResponseInterface
     */
    public function get($uri = null): ResponseInterface;

    /**
     * Make a HEAD request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/HEAD
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getQuery} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see withQuery},
     *                                  {@see setQuery}, {@see where}, or other http query method.
     *
     * @return ResponseInterface
     */
    public function head($uri = null): ResponseInterface;

    /**
     * Make a POST request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/POST
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getQuery} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see withQuery},
     *                                  {@see setQuery}, {@see where}, or other http query method.
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function post($uri = null, array $body = []): ResponseInterface;

    /**
     * Make a PUT request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PUT
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getQuery} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see withQuery},
     *                                  {@see setQuery}, {@see where}, or other http query method.
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function put($uri = null, array $body = []): ResponseInterface;

    /**
     * Make a DELETE request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/DELETE
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getQuery} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see withQuery},
     *                                  {@see setQuery}, {@see where}, or other http query method.
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function delete($uri = null, array $body = []): ResponseInterface;

    /**
     * Make a OPTIONS request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/OPTIONS
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getQuery} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see withQuery},
     *                                  {@see setQuery}, {@see where}, or other http query method.
     *
     * @return ResponseInterface
     */
    public function options($uri = null): ResponseInterface;

    /**
     * Make a PATCH request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PATCH
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getQuery} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see withQuery},
     *                                  {@see setQuery}, {@see where}, or other http query method.
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function patch($uri = null, array $body = []): ResponseInterface;

    /**
     * Make a http request
     *
     * MUST use the PSR-17 {@see createRequest} method to create a request, prior to sending
     * it via the PSR-18 {@see Client::sendRequest} method.
     *
     * SHOULD prepare the request and underlying driver (e.g. transport mechanism) with all
     * required setup and configuration.
     *
     * @param string|null $method [optional] Http method. If none given, then {@see getMethod} MUST be
     *                              used to obtain the desired Http method.
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getQuery} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see withQuery},
     *                                  {@see setQuery}, {@see where}, or other http query method.
     * @param array $options [optional] Driver specific options. These options SHOULD be merged with
     *                       builder's already set options, which SHOULD be obtain via {@see getOptions}.
     *                       The options provided here SHOULD take precedence over the builder's already
     *                       set options, when merging them together.
     *
     *
     * @return ResponseInterface
     */
    public function request(?string $method = null, $uri = null, array $options = []): ResponseInterface;

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
     * Set the base url for the next request
     *
     * @param string $url
     *
     * @return self
     */
    public function withBaseUrl(string $url): self;

    /**
     * Determine if base url is set for next request
     *
     * @return bool
     */
    public function hasBaseUrl(): bool;

    /**
     * Get the base url for the next request
     *
     * @return string
     */
    public function getBaseUrl(): string;

    /**
     * Set the Uri for the next request
     *
     * If the given uri string of {@see UriInterface} contain a
     * http query, then it is extracted and applied onto this
     * builder, via the {@see withQuery} method.
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
     * Alias for {@see withUri}
     *
     * @param string|UriInterface $uri
     *
     * @return self
     *
     * @throws InvalidUriException If given Uri argument is invalid
     */
    public function from($uri): self;

    /**
     * Alias for {@see withUri}
     *
     * @param string|UriInterface $uri
     *
     * @return self
     *
     * @throws InvalidUriException If given Uri argument is invalid
     */
    public function into($uri): self;

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
     * ```
     * $builder
     *      ->where('age', 23)
     *      ->get('/users');
     *
     * // HTTP/1.1 GET /users?age=23
     * ```
     *
     * When all three arguments are provided, the second arguments
     * acts either as a "type" identifier, similar to those used
     * by {@link https://jsonapi.org/format/1.1/#query-parameters}.
     *
     * ```
     * $builder
     *      ->where('age', 'gt', 23)
     *      ->get('/users');
     *
     * // HTTP/1.1 GET /users?age[gt]=23
     * ```
     *
     * If the first argument is a list of fields with values, then
     * both `$type` and `$value` arguments are ignored.
     *
     * ```
     * $builder
     *      ->where([
     *          'age' => 23,
     *          'created_at' => [ 'gt' => 2020 ]
     *      ])
     *      ->get('/users');
     *
     * // HTTP/1.1 GET /users?age=23&created_at[gt]=2020
     * ```
     *
     * @see setQuery
     * @see withQuery
     * @see https://en.wikipedia.org/wiki/Query_string
     * @see https://jsonapi.org/format/1.1/#query-parameters
     *
     * @param string|array $field Field name or List of fields with values
     * @param mixed $type [optional] Identifier (string) or field value
     * @param mixed $value [optional] Field value. Only used if `$type` argument is provided
     *
     * @return self
     */
    public function where($field, $type = null, $value = null): self;

    /**
     * Apply a callback, when result is true
     *
     * Method is inverse of {@see unless}.
     *
     * Any value returned by the callback methods, is ignored.
     *
     * @param bool $result E.g. the boolean result of a condition
     * @param callable $callback The callback to apply, if result is `true`.
     *                          Request builder instance is given as callback's argument.
     * @param callable|null $otherwise [optional] Callback to apply, if result evaluates is `false`.
     *                          Request builder instance is given as callback's argument.
     *
     * @return self
     */
    public function when(bool $result, callable $callback, ?callable $otherwise = null): self;

    /**
     * Apply a callback, unless result is true
     *
     * Method is inverse of {@see when}.
     *
     * Any value returned by the callback methods, is ignored.
     *
     * @param bool $result E.g. the boolean result of a condition
     * @param callable $callback The callback to apply, if result is `false`.
     *                          Request builder instance is given as callback's argument.
     * @param callable|null $otherwise [optional] Callback to apply, if result evaluates is `true`.
     *                          Request builder instance is given as callback's argument.
     *
     * @return self
     */
    public function unless(bool $result, callable $callback, ?callable $otherwise = null): self;

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
     * If data has been set via {@see withData} or {@see setData},
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
     * @param Attachment|array|callable $attachment If a callback is provided, a new {@see Attachment}
     *                          instance will be given as the callback's argument.
     *
     * @return self
     *
     * @throws InvalidAttachmentFormatException
     */
    public function withAttachment($attachment): self;

    /**
     * Add one or more attachments to the next request
     *
     * @see withAttachment
     *
     * @param Attachment[]|callable[] $attachments List of attachments, callbacks or data-arrays
     *                              Callbacks are given new {@see Attachment} instance as argument.
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
     * @see withAttachment
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
     * Creates a new attachment instance.
     *
     * Method does NOT add the attachment into builder's
     * list of attachments.
     *
     * @param array $data [optional]
     *
     * @return Attachment
     */
    public function makeAttachment(array $data = []): Attachment;

    /**
     * Add a cookie for the next request
     *
     * If a Cookie with the same name has already been added,
     * it will be overwritten.
     *
     * @param Cookie|array|callable $cookie If a callback is provided, a new {@see Cookie}
     *                          instance will be given as the callback's argument.
     *
     * @return self
     *
     * @throws InvalidCookieFormatException
     */
    public function withCookie($cookie): self;

    /**
     * Add one or more cookies to the next request
     *
     * @see withCookie
     *
     * @param Cookie[]|callable[] $cookies List of cookies, callbacks or data-arrays
     *                              Callbacks are given new {@see Cookie} instance as argument.
     *
     * @return self
     *
     * @throws InvalidCookieFormatException
     */
    public function withCookies(array $cookies = []): self;

    /**
     * Remove the Cookie that matches given name,
     * for the next request
     *
     * @param string $name
     *
     * @return self
     */
    public function withoutCookie(string $name): self;

    /**
     * Determine if a Cookie has been set, with the
     * given name
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasCookie(string $name): bool;

    /**
     * Get the Cookie with the given name
     *
     * @param string $name
     *
     * @return Cookie|null
     */
    public function getCookie(string $name): ?Cookie;

    /**
     * Get the cookies for the next request
     *
     * @return Cookie[]
     */
    public function getCookies(): array;

    /**
     * Add a cookie for the next request
     *
     * @see withCookie
     *
     * @param string $name
     * @param string|null $value [optional]
     *
     * @return self
     *
     * @throws InvalidCookieFormatException
     */
    public function addCookie(string $name, ?string $value = null): self;

    /**
     * Creates a new cookie instance.
     *
     * Method does NOT add the cookie into builder's list of
     * cookies.
     *
     * @param array $data [optional]
     *
     * @return Cookie
     */
    public function makeCookie(array $data = []): Cookie;

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
     * Remove given option for the next request
     *
     * @param string $name
     *
     * @return self
     */
    public function withoutOption(string $name): self;

    /**
     * Determine if a given option exists for the next
     * request
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasOption(string $name): bool;

    /**
     * Get a specific option for the next request
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getOption(string $name);

    /**
     * Get all the options for the next request
     *
     * @return array
     */
    public function getOptions(): array;

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
