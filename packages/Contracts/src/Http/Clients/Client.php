<?php

namespace Aedart\Contracts\Http\Clients;

use Aedart\Contracts\Http\Clients\Requests\Attachment;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Criteria;
use Aedart\Contracts\Http\Clients\Requests\Query\Builder as Query;
use Aedart\Contracts\Http\Clients\Responses\ResponseExpectation;
use Aedart\Contracts\Http\Cookies\Cookie;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use DateTimeInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Http Client
 *
 * @method ResponseInterface get(string|UriInterface|null $uri = null) Make a GET request.
 * @method ResponseInterface head(string|UriInterface|null $uri = null) Make a HEAD request.
 * @method ResponseInterface post(string|UriInterface|null $uri = null, array $body = []) Make a POST request.
 * @method ResponseInterface put(string|UriInterface|null $uri = null, array $body = []) Make a PUT request.
 * @method ResponseInterface delete(string|UriInterface|null $uri = null, array $body = []) Make a DELETE request.
 * @method ResponseInterface options(string|UriInterface|null $uri = null) Make a OPTIONS request.
 * @method ResponseInterface patch(string|UriInterface|null $uri = null, array $body = []) Make a PATCH request.
 * @method ResponseInterface request(string|null $method = null, string|UriInterface|null $uri = null, array $options = []) Make a http request.
 * @method Builder withMethod(string $method) Set the Http method, for the next request.
 * @method string getMethod() Returns the Http method, for the next request.
 * @method Builder withBaseUrl(string $url) Set the base url for the next request.
 * @method bool hasBaseUrl() Determine if base url is set for next request.
 * @method string getBaseUrl() Get the base url for the next request.
 * @method Builder withUri(string|UriInterface|null $uri) Set the Uri for the next request.
 * @method UriInterface|null getUri() Get Uri for the next request.
 * @method Builder from(string|UriInterface $uri) Alias for withUri.
 * @method Builder into(string|UriInterface $uri) Alias for withUri.
 * @method Builder withHeaders(array $headers = []) Set the Http headers for the next request.
 * @method Builder withHeader(string $name, mixed $value) Set a Http header for the next request.
 * @method Builder withoutHeader(string $name) Remove a Http header from the next request.
 * @method array getHeaders() Get all the Http headers for the next request.
 * @method mixed getHeader(string $name) Get the desired Http header, for the next request.
 * @method Builder useProtocolVersion(string $version) Set the HTTP protocol version, for the next request.
 * @method string getProtocolVersion() Get the HTTP protocol version, for the next request.
 * @method Builder withAccept(string $contentType) Use given "Accept" header for the next request.
 * @method Builder withContentType(string $contentType) Use given Content-Type for the next request.
 * @method Builder formFormat() Use application/x-www-form-urlencoded as next request's body format.
 * @method Builder jsonFormat() Use json as data format as next request's body format.
 * @method Builder multipartFormat() Use multipart/form-data as next request's body format.
 * @method string useDataFormat(string $format) Use the given data format for the next request.
 * @method string getDataFormat() Get the data format to use for the next request.
 * @method Builder useBasicAuth(string $username, string $password) Use Basic Http Authentication, for the next request.
 * @method Builder useDigestAuth(string $username, string $password) Use Digest Authentication, for the next request.
 * @method Builder useTokenAuth(string $token, string $scheme = 'Bearer') Use a token as authentication, for the next request.
 * @method Builder maxRedirects(int $amount) Set the maximum amount of redirects to follow, for the next request.
 * @method Builder disableRedirects() Disables the follow redirects behaviour, for the next request.
 * @method Builder withTimeout(float $seconds) Set the next request's timeout.
 * @method float getTimeout() Get the next request's timeout.
 * @method Query query() Returns the existing Http Query Builder.
 * @method Query newQuery() Returns a new Http Query Builder instance.
 * @method Builder setQuery(Query $query) Set the Http Query Builder.
 * @method Builder applyCriteria(Criteria|Criteria[] $criteria) Apply one or more criteria for the next request.
 * @method Builder when(bool $result, callable $callback, callable|null $otherwise = null) Apply a callback, when result is true.
 * @method Builder unless(bool $result, callable $callback, callable|null $otherwise = null) Apply a callback, unless result is true.
 * @method Builder withData(array $data) Add data to the next request's payload (body).
 * @method Builder setData(array $data) Set the next request's payload (body).
 * @method bool hasData() Determine if next request has payload data.
 * @method array getData() Get the next request's payload (body).
 * @method Builder withRawPayload(mixed $body) Set the next request's raw payload (body).
 * @method mixed getRawPayload() Get the next request's raw payload (body).
 * @method bool hasRawPayload() Determine if the next request has a raw payload (body) set.
 * @method Builder withAttachment(Attachment|array|callable $attachment) Add an attachment to the next request.
 * @method Builder withAttachments(Attachment[]|callable[] $attachments = []) Add one or more attachments to the next request.
 * @method Builder withoutAttachment(string $name) Remove an attachment from the next request.
 * @method bool hasAttachment(string $name) Determine if an attachment exists.
 * @method Attachment|null getAttachment(string $name) Get the attachment with the given name.
 * @method Attachment[] getAttachments() Get the attachments for the next request.
 * @method Builder attachFile(string $name, string $path, array $headers = [], string|null $filename = null) Attach a file to the next request.
 * @method Attachment makeAttachment(array $data = []) Creates a new attachment instance.
 * @method Builder withCookie(Cookie|array|callable $cookie) Add a cookie for the next request.
 * @method Builder withCookies(Cookie[]|callable[] $cookies = []) Add one or more cookies to the next request.
 * @method Builder withoutCookie(string $name) Remove the Cookie that matches given name, for the next request.
 * @method bool hasCookie(string $name) Determine if a Cookie has been set, with the given name.
 * @method Cookie|null getCookie(string $name) Get the Cookie with the given name.
 * @method Cookie[] getCookies() Get the cookies for the next request.
 * @method Builder addCookie(string $name, string|null $value = null) Add a cookie for the next request.
 * @method Cookie makeCookie(array $data = []) Creates a new cookie instance.
 * @method Builder expect(int|int[] $status, callable|ResponseExpectation|null $otherwise = null) Expect response's http status code to match given code or be amongst a list of valid codes.
 * @method Builder withExpectation(callable|ResponseExpectation $expectation) Add an expectation for the next response.
 * @method Builder withExpectations(callable[]|ResponseExpectation[] $expectations = []) Add one or more expectations for the next request.
 * @method bool hasExpectations() Determine if any expectations have been added for the next request.
 * @method ResponseExpectation[] getExpectations() Returns list of expectations for the next request.
 * @method Builder withMiddleware(string|Middleware|string[]|Middleware[] $middleware) Add middleware to process next outgoing request, and its incoming response.
 * @method Builder prependMiddleware(string|Middleware $middleware) Add middleware at the beginning of the middleware list
 * @method Builder pushMiddleware(string|Middleware $middleware) Append middleware to the end of the middleware list
 * @method bool hasMiddleware() Determine whether middleware has been assign for the next request or not
 * @method Middleware[] getMiddleware() Returns list of middleware that must process next outgoing request, and its incoming response.
 * @method Builder withoutMiddleware() Removes assigned middleware for the next request.
 * @method Builder withOption(string $name, mixed $value) Set a specific option for the next request.
 * @method Builder withOptions(array $options = []) Apply a set of options for the next request.
 * @method Builder withoutOption(string $name) Remove given option for the next request.
 * @method bool hasOption(string $name) Determine if a given option exists for the next request.
 * @method mixed getOption(string $name) Get a specific option for the next request.
 * @method array getOptions() Get all the options for the next request.
 * @method Builder debug(callable|null $callback = null) Dumps the next outgoing request and received response.
 * @method Builder dd(callable|null $callback = null) Dumps the next outgoing request and exists the running script.
 * @method callable debugCallback() Returns the last assigned debugging callback. If no debugging method was assigned, method returns a callback that does not do anything.
 * @method Builder log(callable|null $callback = null)  Log the next outgoing request and received response.
 * @method callable logCallback() Returns the last assigned logging callback. If no method was assigned, method returns a callback that does not do anything.
 * @method self client() Get the http client.
 *
 * @method Builder select(string|string[] $field, string|null $resource = null) Select the fields to be returned.
 * @method Builder selectRaw(string $expression, array $bindings = []) Select a raw expression.
 * @method Builder where(string|array $field, mixed $operator = null, mixed $value = null) Add a "where" condition or filter.
 * @method Builder orWhere(string|array $field, mixed $operator = null, mixed $value = null) Add a "or where" condition or filter.
 * @method Builder whereRaw(string $query, array $bindings = []) Add a raw "where" condition or filter.
 * @method Builder orWhereRaw(string $query, array $bindings = []) Add a raw "or where" condition or filter.
 * @method Builder whereDatetime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where datetime" condition or filter.
 * @method Builder orWhereDatetime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "or where datetime" condition or filter.
 * @method Builder whereDate(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where date" condition or filter.
 * @method Builder orWhereDate(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "or where date" condition or filter.
 * @method Builder whereYear(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where year" condition or filter.
 * @method Builder orWhereYear(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "or where year" condition or filter.
 * @method Builder whereMonth(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where month" condition or filter.
 * @method Builder orWhereMonth(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "or where month" condition or filter.
 * @method Builder whereDay(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where day" condition or filter.
 * @method Builder orWhereDay(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "or where day" condition or filter.
 * @method Builder whereTime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where time" condition or filter.
 * @method Builder orWhereTime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null) Add a "where time" condition or filter.
 * @method Builder include(string|string[] $resource) Include one or more related resources in the response.
 * @method Builder limit(int $amount) Limit the amount of results to be returned.
 * @method Builder offset(int $offset) Skip over given amount of results.
 * @method Builder take(int $amount) Alias for limit.
 * @method Builder skip(int $offset) Alias for offset.
 * @method Builder page(int $number, int|null $size = null) Return result for requested page number.
 * @method Builder show(int|null $amount = null) Set amount of results to be returned per page.
 * @method Builder orderBy(string|string[] $field, string $direction = 'asc') Order results by given field or fields.
 * @method Builder raw(string $expression, array $bindings = []) Add a raw expression.
 * @method string build() Build http query string.
 *
 * @see \Aedart\Contracts\Http\Clients\Requests\Builder
 * @see \Aedart\Contracts\Http\Clients\Requests\Query\Builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients
 */
interface Client extends
    ClientInterface,
    ContainerAware
{
    /**
     * Returns this Http Client's initial options
     *
     * @return array
     */
    public function getClientOptions(): array;

    /**
     * Get this Http Client's native driver
     *
     * @return mixed
     */
    public function driver(): mixed;

    /**
     * Creates and returns a new Http Request Builder
     *
     * @return Builder
     */
    public function makeBuilder(): Builder;
}
