<?php

namespace Aedart\Contracts\Http\Clients\Requests;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Exceptions\ExpectationNotMetException;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidAttachmentFormatException;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidCookieFormatException;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidUriException;
use Aedart\Contracts\Http\Clients\HttpClientAware;
use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Query\Builder as Query;
use Aedart\Contracts\Http\Clients\Responses\ResponseExpectation;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Contracts\Http\Cookies\Cookie;
use Aedart\Contracts\Http\Messages\Type;
use Aedart\Contracts\Streams\Stream;
use DateTimeInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Throwable;

/**
 * Http Request Builder
 *
 * @method self select(string|string[] $field, string|null $resource = null) Select the fields to be returned.
 * @method self selectRaw(string $expression, array $bindings = []) Select a raw expression.
 * @method self where(string|array $field, mixed $operator = null, mixed $value = null) Add a "where" condition or filter.
 * @method self orWhere(string|array $field, mixed $operator = null, mixed $value = null) Add a "or where" condition or filter.
 * @method self whereRaw(string $query, array $bindings = []) Add a raw "where" condition or filter.
 * @method self orWhereRaw(string $query, array $bindings = []) Add a raw "or where" condition or filter.
 * @method self whereDatetime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where datetime" condition or filter.
 * @method self orWhereDatetime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "or where datetime" condition or filter.
 * @method self whereDate(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where date" condition or filter.
 * @method self orWhereDate(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "or where date" condition or filter.
 * @method self whereYear(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where year" condition or filter.
 * @method self orWhereYear(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "or where year" condition or filter.
 * @method self whereMonth(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where month" condition or filter.
 * @method self orWhereMonth(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "or where month" condition or filter.
 * @method self whereDay(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where day" condition or filter.
 * @method self orWhereDay(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "or where day" condition or filter.
 * @method self whereTime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where time" condition or filter.
 * @method self orWhereTime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where time" condition or filter.
 * @method self include(string|string[] $resource) Include one or more related resources in the response.
 * @method self limit(int $amount) Limit the amount of results to be returned.
 * @method self offset(int $offset) Skip over given amount of results.
 * @method self take(int $amount) Alias for limit.
 * @method self skip(int $offset) Alias for offset.
 * @method self page(int $number, int|null $size = null) Return result for requested page number.
 * @method self show(int|null $amount = null) Set amount of results to be returned per page.
 * @method self orderBy(string|string[] $field, string $direction = 'asc') Order results by given field or fields.
 * @method self raw(string $expression, array $bindings = []) Add a raw expression.
 * @method string build() Build http query string.
 *
 * @see \Aedart\Contracts\Http\Clients\Requests\Query\Builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests
 */
interface Builder extends HttpClientAware,
    RequestFactoryInterface
{
    /**
     * Perform a GET request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/GET
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getUri} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see query}
     *
     * @return ResponseInterface
     */
    public function get(string|UriInterface|null $uri = null): ResponseInterface;

    /**
     * Perform a HEAD request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/HEAD
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getUri} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see query}
     *
     * @return ResponseInterface
     */
    public function head(string|UriInterface|null $uri = null): ResponseInterface;

    /**
     * Perform a POST request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/POST
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getUri} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see query}
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function post(string|UriInterface|null $uri = null, array $body = []): ResponseInterface;

    /**
     * Perform a PUT request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PUT
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getUri} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see query}
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function put(string|UriInterface|null $uri = null, array $body = []): ResponseInterface;

    /**
     * Perform a DELETE request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/DELETE
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getUri} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see query}
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function delete(string|UriInterface|null $uri = null, array $body = []): ResponseInterface;

    /**
     * Perform a OPTIONS request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/OPTIONS
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getUri} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see query}
     *
     * @return ResponseInterface
     */
    public function options(string|UriInterface|null $uri = null): ResponseInterface;

    /**
     * Perform a PATCH request
     *
     * MUST use the {@see request} method to perform actual request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PATCH
     *
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getUri} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see query}
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function patch(string|UriInterface|null $uri = null, array $body = []): ResponseInterface;

    /**
     * Perform an http request
     *
     * MUST use the PSR-17 {@see createRequest} method to create a request, prior to sending
     * it via the PSR-18 {@see Client::sendRequest} method.
     *
     * SHOULD prepare the request and underlying driver (e.g. transport mechanism) with all
     * required setup and configuration.
     *
     * MUST invoke added response expectation callbacks delivered by {@see getExpectations}, prior to
     * returning the received response.
     *
     * @param string|null $method [optional] Http method. If none given, then {@see getMethod} MUST be
     *                              used to obtain the desired Http method.
     * @param string|UriInterface|null $uri [optional] If none given, then Uri from {@see getUri} MUST be used.
     *                                  Http query is ignored if it is set via builder's {@see query}
     * @param array $options [optional] Driver specific options. These options SHOULD be merged with
     *                       builder's already set options, which SHOULD be obtained via {@see getOptions}.
     *                       The options provided here SHOULD take precedence over the builder's already
     *                       set options, when merging them together.
     *
     *
     * @return ResponseInterface
     *
     * @throws Throwable
     */
    public function request(string|null $method = null, string|UriInterface|null $uri = null, array $options = []): ResponseInterface;

    /**
     * Set the Http method, for the next request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
     *
     * @param string $method
     *
     * @return self
     */
    public function withMethod(string $method): static;

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
    public function withBaseUrl(string $url): static;

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
     * builder, via the Http Query Builder provided by the
     * {@see query} method.
     *
     * @param string|UriInterface $uri
     *
     * @return self
     *
     * @throws InvalidUriException If given Uri argument is invalid
     */
    public function withUri(string|UriInterface $uri): static;

    /**
     * Get Uri for the next request
     *
     * @return UriInterface|null
     */
    public function getUri(): UriInterface|null;

    /**
     * Alias for {@see withUri}
     *
     * @param string|UriInterface $uri
     *
     * @return self
     *
     * @throws InvalidUriException If given Uri argument is invalid
     */
    public function from(string|UriInterface $uri): static;

    /**
     * Alias for {@see withUri}
     *
     * @param string|UriInterface $uri
     *
     * @return self
     *
     * @throws InvalidUriException If given Uri argument is invalid
     */
    public function into(string|UriInterface $uri): static;

    /**
     * Set the Http headers for the next request
     *
     * Method will merge with existing headers, if client has any predefined
     *
     * @param array $headers [optional] Key-value pair
     *
     * @return self
     */
    public function withHeaders(array $headers = []): static;

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
    public function withHeader(string $name, mixed $value): static;

    /**
     * Remove a Http header from the next request
     *
     * @param string $name
     *
     * @return self
     */
    public function withoutHeader(string $name): static;

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
    public function getHeader(string $name): mixed;

    /**
     * Set the HTTP protocol version, for the next request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Messages
     *
     * @param string $version
     *
     * @return self
     */
    public function useProtocolVersion(string $version): static;

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
    public function withAccept(string $contentType): static;

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
    public function withContentType(string $contentType): static;

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
     * Use JSON as data format as next request's body format.
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
    public function useDataFormat(string $format): static;

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
     * @param string $scheme [optional] Authentication Scheme
     *
     * @return self
     */
    public function useTokenAuth(string $token, string $scheme = 'Bearer'): static;

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
     * Returns the existing Http Query Builder
     *
     * Method MUST create a new Http Query Builder instance, via
     * {@see newQuery} if an instance has not yet been created.
     * Additionally, method MUST use {@see setQuery} to set the
     * query builder internally for this request builder.
     *
     * @return Query
     */
    public function query(): Query;

    /**
     * Returns a new Http Query Builder instance
     *
     * @return Query
     */
    public function newQuery(): Query;

    /**
     * Set the Http Query Builder
     *
     * @param Query $query
     *
     * @return self
     */
    public function setQuery(Query $query): static;

    /**
     * Apply one or more criteria for the next request
     *
     * @see Criteria
     *
     * @param Criteria|Criteria[] $criteria
     *
     * @return self
     */
    public function applyCriteria(array|Criteria $criteria): static;

    /**
     * Apply a callback, when result is true
     *
     * Method is inverse of {@see unless}.
     *
     * Any value returned by the callback methods, is ignored.
     *
     * @param bool|callable(Builder): bool $result E.g. the boolean result of a condition. If callback is given, then its
     *                              resulting value is used as result.
     * @param callable(Builder): void $callback The callback to apply, if result is `true`.
     *                          Request builder instance is given as callback's argument.
     * @param callable(Builder): (void)|null $otherwise [optional] Callback to apply, if result evaluates is `false`.
     *                          Request builder instance is given as callback's argument.
     *
     * @return self
     */
    public function when(bool|callable $result, callable $callback, callable|null $otherwise = null): static;

    /**
     * Apply a callback, unless result is true
     *
     * Method is inverse of {@see when}.
     *
     * Any value returned by the callback methods, is ignored.
     *
     * @param bool|callable(Builder): bool $result E.g. the boolean result of a condition. If callback is given, then its
     *                              resulting value is used as result.
     * @param callable(Builder): void $callback The callback to apply, if result is `false`.
     *                          Request builder instance is given as callback's argument.
     * @param callable(Builder): (void)|null $otherwise [optional] Callback to apply, if result evaluates is `true`.
     *                          Request builder instance is given as callback's argument.
     *
     * @return self
     */
    public function unless(bool|callable $result, callable $callback, callable|null $otherwise = null): static;

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
    public function withData(array $data): static;

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
    public function setData(array $data): static;

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
    public function withRawPayload(mixed $body): static;

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
    public function getRawPayload(): mixed;

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
     * @param Attachment|array|callable(Attachment): void $attachment If a callback is provided, a new {@see Attachment}
     *                          instance will be given as the callback's argument.
     *
     * @return self
     *
     * @throws InvalidAttachmentFormatException
     */
    public function withAttachment(Attachment|array|callable $attachment): static;

    /**
     * Add one or more attachments to the next request
     *
     * @see withAttachment
     *
     * @param array<Attachment|array|callable(Attachment): void> $attachments List of attachments, callbacks or data-arrays.
     *                              Callbacks are given new {@see Attachment} instance as argument.
     *
     * @return self
     *
     * @throws InvalidAttachmentFormatException
     */
    public function withAttachments(array $attachments = []): static;

    /**
     * Remove an attachment from the next request
     *
     * @param string $name Form input name
     *
     * @return self
     */
    public function withoutAttachment(string $name): static;

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
    public function getAttachment(string $name): Attachment|null;

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
        string|null $filename = null
    ): static;

    /**
     * Attach file using a stream
     *
     * @param string $name Form input name
     * @param Stream|resource $stream
     * @param array $headers [optional] Http headers for attachment
     * @param string|null $filename [optional] Filename to be used by request
     * @return self
     */
    public function attachStream(
        string $name,
        $stream,
        array $headers = [],
        string|null $filename = null
    ): static;

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
     * @param Cookie|array|callable(Cookie): void $cookie If a callback is provided, a new {@see Cookie}
     *                          instance will be given as the callback's argument.
     *
     * @return self
     *
     * @throws InvalidCookieFormatException
     */
    public function withCookie(Cookie|array|callable $cookie): static;

    /**
     * Add one or more cookies to the next request
     *
     * @see withCookie
     *
     * @param array<Cookie|array|callable(Cookie): void> $cookies List of cookies, callbacks or data-arrays
     *                              Callbacks are given new {@see Cookie} instance as argument.
     *
     * @return self
     *
     * @throws InvalidCookieFormatException
     */
    public function withCookies(array $cookies = []): static;

    /**
     * Remove the Cookie that matches given name,
     * for the next request
     *
     * @param string $name
     *
     * @return self
     */
    public function withoutCookie(string $name): static;

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
    public function getCookie(string $name): Cookie|null;

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
    public function addCookie(string $name, string|null $value = null): static;

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
     * Expect the received response's http status code to match given code
     * or be amongst a list of valid codes.
     *
     * Once a response has been received, it's http status code is matched
     * against given expected status code(s). If it does not match, then
     * method MUST invoke `$otherwise` callback, if argument is provided.
     *
     * Method MUST build and add expectation via the {@see withExpectation} method.
     *
     * @param  callable(Status $status, ResponseInterface $response, RequestInterface $request): (void)|int|int[]|ResponseExpectation  $status
     *                                  Expected http status code(s). If a callback is provided,
     *                                  then it MUST be added as an expectation via {@see withExpectation}.
     *                                  Second argument is ignored, if callback is given.
     * @param callable(Status $status, ResponseInterface $response, RequestInterface $request): (void)|null $otherwise [optional]
     *                              Callback to be invoked if received http status code
     *                              does not match. If no callback is given, a {@see ExpectationNotMetException}
     *                              will be thrown, if received status code does not match.
     *                              This argument is IGNORED, if first argument is a callback or
     *
     * @return self
     *
     * @throws ExpectationNotMetException
     * @throws Throwable
     */
    public function expect(callable|array|int|ResponseExpectation $status, callable|null $otherwise = null): static;

    /**
     * Add an expectation for the next response.
     *
     * An "expectation" is a callback that verifies the received response's Http status code, Http headers, and possibly
     * its payload body. If the response is considered invalid, the callback SHOULD throw an exception.
     *
     * Given callback will be invoked after a response has been received, in the {@see request} method.
     *
     * @param  ResponseExpectation|callable(Status $status, ResponseInterface $response, RequestInterface $request): void  $expectation
     *                  Expectation callback.
     *
     * @return self
     */
    public function withExpectation(callable|ResponseExpectation $expectation): static;

    /**
     * Add one or more expectations for the next request.
     *
     * MUST add given list of expectations via the {@see withExpectation} method.
     *
     * @param array<ResponseExpectation|callable(Status $status, ResponseInterface $response, RequestInterface $request): void> $expectations [optional]
     *
     * @return self
     */
    public function withExpectations(array $expectations = []): static;

    /**
     * Determine if any expectations have been added for
     * the next request.
     *
     * @see withExpectation
     *
     * @return bool
     */
    public function hasExpectations(): bool;

    /**
     * Returns list of expectations for the next
     * request.
     *
     * @see withExpectation
     *
     * @return ResponseExpectation[]
     */
    public function getExpectations(): array;

    /**
     * Add middleware to process next outgoing request, and it's
     * incoming response
     *
     * @param  class-string<Middleware>|Middleware|array<class-string<Middleware>|Middleware>  $middleware Class path, Middleware instance or list hereof
     *
     * @return self
     */
    public function withMiddleware(array|string|Middleware $middleware): static;

    /**
     * Add middleware at the beginning of the middleware list
     *
     * @param  class-string<Middleware>|Middleware  $middleware Class path or Middleware instance
     *
     * @return self
     */
    public function prependMiddleware(string|Middleware $middleware): static;

    /**
     * Append middleware to the end of the middleware list
     *
     * @param  class-string<Middleware>|Middleware  $middleware Class path or Middleware instance
     *
     * @return self
     */
    public function pushMiddleware(string|Middleware $middleware): static;

    /**
     * Determine whether middleware has been assign
     * for the next request, or not
     *
     * @see withMiddleware
     *
     * @return bool
     */
    public function hasMiddleware(): bool;

    /**
     * Returns list of middleware that must process next outgoing
     * request, and it's incoming response
     *
     * @return Middleware[]
     */
    public function getMiddleware(): array;

    /**
     * Removes assigned middleware for the next request
     *
     * @return self
     */
    public function withoutMiddleware(): static;

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
    public function withOption(string $name, mixed $value): static;

    /**
     * Apply a set of options for the next request
     *
     * Method will merge given options with Client's default options
     *
     * @param array $options [optional]
     *
     * @return self
     */
    public function withOptions(array $options = []): static;

    /**
     * Remove given option for the next request
     *
     * @param string $name
     *
     * @return self
     */
    public function withoutOption(string $name): static;

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
    public function getOption(string $name): mixed;

    /**
     * Get all the options for the next request
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * Log the next outgoing request and received response
     *
     * Note: This method is intended for "selective" logging
     * of requests / responses. E.g. for debugging.
     * If you require more logging control, then consider
     * using custom {@see Middleware} instead of this method.
     *
     * @param callable(Type $type, MessageInterface $message, Builder $builder): (void)|null $callback  [optional]
     *                                 Custom callback for logging Http message.
     *                                 If no callback is provided, then a default logging callback is applied.
     *
     * @return self
     */
    public function log(callable|null $callback = null): static;

    /**
     * Returns the last assigned logging callback.
     * If no method was assigned, method returns
     * a callback that does not do anything.
     *
     * @see log
     *
     * @return callable(Type $type, MessageInterface $message, Builder $builder): void
     */
    public function logCallback(): callable;

    /**
     * Dumps the next outgoing request and received response
     *
     * WARNING: Method SHOULD NOT be used in a production
     * environment.
     *
     * Example:
     * ```
     * $client
     *      ->debug(function($type, $httpMessage, $requestBuilder) {
     *          // $type is either 'request' or 'response'
     *          // ... perform debugging of http message ...
     *      })
     *      ->get('/users');
     * ```
     *
     * @param callable(Type $type, MessageInterface $message, Builder $builder): (void)|null $callback  [optional]
     *                                  Custom callback for performing Http message debugging.
     *                                  If no callback is provided, then a default debugging callback is applied.
     *
     * @return self
     */
    public function debug(callable|null $callback = null): static;

    /**
     * Dumps the next outgoing request and exists the
     * running script.
     *
     * WARNING: Method SHOULD NOT be used in a production
     * environment.
     *
     * Example:
     * ```
     * $client
     *      ->dd(function($type, $httpMessage, $requestBuilder) {
     *          // $type is either 'request' or 'response'
     *          // ... perform debugging of http message ...
     *
     *          exit(1); // Manual exit of script!
     *      })
     *      ->get('/users');
     * ```
     *
     * @param callable(Type $type, MessageInterface $message, Builder $builder): (void)|null $callback  [optional]
     *                                 Custom callback for performing Http message debugging.
     *                                 If no callback is provided, then a default debugging callback is applied.
     *
     * @return self
     */
    public function dd(callable|null $callback = null): static;

    /**
     * Returns the last assigned debugging callback.
     *
     * If no debugging method was assigned, method returns
     * a callback that does not do anything.
     *
     * @see debug
     * @see dd
     *
     * @return callable(Type $type, MessageInterface $message, Builder $builder): void
     */
    public function debugCallback(): callable;

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
    public function driver(): mixed;
}
