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
     * @inheritdoc
     */
    public function withHeaders(array $headers = []): static
    {
        $this->headers = array_merge_recursive($this->headers, $headers);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withHeader(string $name, $value): static
    {
        return $this->withHeaders([ $name => $value ]);
    }

    /**
     * @inheritdoc
     */
    public function withoutHeader(string $name): static
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
     * @inheritdoc
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @inheritdoc
     */
    public function getHeader(string $name): mixed
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
    public function withAccept(string $contentType): static
    {
        return $this
            ->withoutHeader('Accept')
            ->withHeader('Accept', $contentType);
    }

    /**
     * @inheritdoc
     */
    public function withContentType(string $contentType): static
    {
        return $this
            ->withoutHeader('Content-Type')
            ->withHeader('Content-Type', $contentType);
    }

    /**
     * @inheritdoc
     */
    public function useTokenAuth(string $token, string $scheme = 'Bearer'): static
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
