<?php

namespace Aedart\Http\Api\Resources\Concerns;

use Aedart\Contracts\ETags\CanGenerateEtag;
use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\ETags\HasEtag;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Concerns Http Caching
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cache-Control
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Concerns
 */
trait HttpCaching
{
    /**
     * Http Cache Headers to apply
     *
     * @var array
     */
    protected array $cacheHeaders = [];

    /**
     * Applies cache headers to response
     *
     * @param  array  $headers  [optional] Http headers to be merged with
     *                          {@see defaultCacheHeaders()}.
     *
     * @return self
     */
    public function withCache(array $headers = []): static
    {
        $this->cacheHeaders = array_merge(
            $this->defaultCacheHeaders(),
            $headers
        );

        return $this;
    }

    /**
     * Set this resource's ETag
     *
     * @param string|ETag|null $etag
     *
     * @return self
     */
    public function withEtag(string|ETag|null $etag): static
    {
        $this->cacheHeaders['etag'] = $etag;

        return $this;
    }

    /**
     * Get this resource's ETag
     *
     * @return string|ETag|null
     *
     * @throws ETagGeneratorException
     */
    public function getEtag(): string|ETag|null
    {
        if (!isset($this->cacheHeaders['etag'])) {
            $this->withEtag($this->resolveResourceEtag());
        }

        return $this->cacheHeaders['etag'];
    }

    /**
     * Removes ETag from this resource's "cache" headers
     *
     * @return self
     */
    public function withoutEtag(): static
    {
        unset($this->cacheHeaders['etag']);

        return $this;
    }

    /**
     * Set this resource's last modified date
     *
     * @param string|DateTimeInterface|null $lastModified
     *
     * @return self
     */
    public function withLastModifiedDate(string|DateTimeInterface|null $lastModified): static
    {
        $this->cacheHeaders['last_modified'] = $lastModified;

        return $this;
    }

    /**
     * Get this resource's last modified date
     *
     * @return string|DateTimeInterface|null
     */
    public function getLastModifiedDate(): string|DateTimeInterface|null
    {
        if (!isset($this->cacheHeaders['last_modified'])) {
            $this->withLastModifiedDate($this->resolveResourceLastModifiedDate());
        }

        return $this->cacheHeaders['last_modified'];
    }

    /**
     * Removes last modified date from this resource's cache headers
     *
     * @return self
     */
    public function withoutLastModifiedDate(): static
    {
        unset($this->cacheHeaders['last_modified']);

        return $this;
    }

    /**
     * Returns predefined Http cache headers
     *
     * @see \Symfony\Component\HttpFoundation\Response::setCache
     *
     * @return array
     *
     * @throws ETagGeneratorException
     */
    public function defaultCacheHeaders(): array
    {
        return [
            'etag' => $this->getEtag(),
            'last_modified' => $this->getLastModifiedDate(),
            'private' => true,

            'max_age' => null,
            's_maxage' => null,
            'must_revalidate' => false,
            'no_cache' => true,
            'no_store' => false,
            'no_transform' => false,
            'public' => false,
            'proxy_revalidate' => false,
            'immutable' => false,
        ];
    }

    /**
     * Sets http cache headers for given response
     *
     * @see \Aedart\ETags\Mixins\ResponseETagsMixin::withCache
     *
     * @param \Illuminate\Http\JsonResponse $response
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyCacheHeaders($response, $request)
    {
        if (empty($this->cacheHeaders)) {
            return $response;
        }

        $headers = $this->prepareCacheHeaders(
            $this->cacheHeaders,
            $request,
            $response
        );

        return $response->withCache(
            etag: $headers['etag'] ?? null,
            lastModified: $headers['last_modified'] ?? null,
            maxAge: $headers['max_age'] ?? null,
            sharedMaxAge: $headers['s_maxage'] ?? null,
            public: $headers['public'] ?? false,
            private: $headers['private'] ?? false,
            mustRevalidate: $headers['must_revalidate'] ?? false,
            noCache: $headers['no_cache'] ?? false,
            noStore: $headers['no_store'] ?? false,
            noTransform: $headers['no_transform'] ?? false,
            proxyRevalidate: $headers['proxy_revalidate'] ?? false,
            immutable: $headers['immutable'] ?? false,
        );
    }

    /**
     * Prepares the Http Cache headers
     *
     * @param  array  $cacheHeaders
     * @param \Illuminate\Http\Request  $request
     * @param \Illuminate\Http\JsonResponse $response
     *
     * @return array
     */
    protected function prepareCacheHeaders(array $cacheHeaders, $request, $response): array
    {
        // Overwrite this method, if you require to adapt Http cache headers,
        // based on given request and response.

        return $cacheHeaders;
    }

    /**
     * Resolves an ETag representation of the resource, if possible
     *
     * @return ETag|string|null
     *
     * @throws ETagGeneratorException
     */
    protected function resolveResourceEtag(): ETag|string|null
    {
        $resource = $this->resource;

        return match (true) {
            $resource instanceof HasEtag || method_exists($resource, 'getStrongEtag') => $resource->getStrongEtag(),
            $resource instanceof CanGenerateEtag || method_exists($resource, 'makeStrongEtag') => $resource->makeStrongEtag(),
            default => null
        };
    }

    /**
     * Resolves the resource's "last modified date" if available
     *
     * @return string|DateTimeInterface|null
     */
    protected function resolveResourceLastModifiedDate(): string|DateTimeInterface|null
    {
        $resource = $this->resource;

        // Skip if resource isn't a model...
        if (!($resource instanceof Model)) {
            return null;
        }

        $updatedAtKey = $resource->getUpdatedAtColumn();
        return $resource[$updatedAtKey] ?? null;
    }
}
