<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Concerns Http Headers
 *
 * @see Builder
 * @see Builder::withHeaders
 * @see Builder::withHeader
 * @see Builder::withoutHeader
 * @see Builder::getHeaders
 * @see Builder::getHeader
 * @see Builder::withAccept
 * @see Builder::withContentType
 * @see Builder::useTokenAuth

 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait HttpHeaders
{
    /**
     * The Http Headers to send
     *
     * @var array
     */
    protected array $headers = [];

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
     * Set the Http headers for the next request
     *
     * Method will merge with existing headers, if client has any predefined
     *
     * @param array $headers [optional] Key-value pair
     *
     * @return self
     */
    public function withHeaders(array $headers = []): Builder
    {
        $this->headers = array_merge_recursive($this->headers, $headers);

        return $this;
    }

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
    public function withHeader(string $name, $value): Builder
    {
        return $this->withHeaders([ $name => $value ]);
    }

    /**
     * Remove a Http header from the next request
     *
     * @param string $name
     *
     * @return self
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
     * Get all the Http headers for the next request
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get the desired Http header, for the next request
     *
     * @param string $name Case-insensitive
     *
     * @return mixed
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
    public function withAccept(string $contentType): Builder
    {
        return $this
            ->withoutHeader('Accept')
            ->withHeader('Accept', $contentType);
    }

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
    public function withContentType(string $contentType): Builder
    {
        return $this
            ->withoutHeader('Content-Type')
            ->withHeader('Content-Type', $contentType);
    }

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
    public function useTokenAuth(string $token, string $scheme = 'Bearer'): Builder
    {
        return $this
            ->withoutHeader('Authorization')
            ->withHeader('Authorization', trim($scheme . ' ' . $token));
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

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
