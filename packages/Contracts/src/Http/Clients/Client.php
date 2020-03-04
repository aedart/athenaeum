<?php

namespace Aedart\Contracts\Http\Clients;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Http Client
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients
 */
interface Client
{
    /**
     * Make a GET request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/GET
     *
     * @param string|UriInterface $uri
     *
     * @return ResponseInterface
     */
    public function get($uri): ResponseInterface;

    /**
     * Make a HEAD request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/HEAD
     *
     * @param string|UriInterface $uri
     *
     * @return ResponseInterface
     */
    public function head($uri): ResponseInterface;

    /**
     * Make a POST request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/POST
     *
     * @param string|UriInterface $uri
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function post($uri, array $body = []): ResponseInterface;

    /**
     * Make a PUT request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PUT
     *
     * @param string|UriInterface $uri
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function put($uri, array $body = []): ResponseInterface;

    /**
     * Make a DELETE request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/DELETE
     *
     * @param string|UriInterface $uri
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function delete($uri, array $body = []): ResponseInterface;

    /**
     * Make a OPTIONS request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/OPTIONS
     *
     * @param string|UriInterface $uri
     *
     * @return ResponseInterface
     */
    public function options($uri): ResponseInterface;

    /**
     * Make a PATCH request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PATCH
     *
     * @param string|UriInterface $uri
     * @param array $body [optional]
     *
     * @return ResponseInterface
     */
    public function patch($uri, array $body = []): ResponseInterface;

    /**
     * Make a http request
     *
     * @param string $method Http method name
     * @param string|UriInterface $uri
     * @param array $options [optional]
     *
     * @return ResponseInterface
     */
    public function request(string $method, $uri, array $options = []): ResponseInterface;

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
    public function setTimeout(float $seconds): self;

    /**
     * Get the next request's timeout
     *
     * @return float Duration in seconds
     */
    public function getTimeout(): float;

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
     * Get this Http Client's native driver
     *
     * @return mixed
     */
    public function driver();
}
