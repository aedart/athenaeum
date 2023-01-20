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
            'etag' => $this->getResourceEtag(),
            'last_modified' => $this->getResourceLastModifiedDate(),
            'private' => true,

            'max_age' => null,
            's_maxage' => null,
            'must_revalidate' => false,
            'no_cache' => false,
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
     * Returns an ETag representation of the resource, if possible
     *
     * @return ETag|string|null
     *
     * @throws ETagGeneratorException
     */
    public function getResourceEtag(): ETag|string|null
    {
        $resource = $this->resource;

        return match (true) {
            $resource instanceof HasEtag || method_exists($resource, 'getStrongEtag') => $resource->getStrongEtag(),
            $resource instanceof CanGenerateEtag || method_exists($resource, 'makeStrongEtag') => $resource->makeStrongEtag(),
            default => null
        };
    }

    /**
     * Returns the resource's "last modified date" if available
     *
     * @return string|DateTimeInterface|null
     */
    public function getResourceLastModifiedDate(): string|DateTimeInterface|null
    {
        $resource = $this->resource;

        // Skip if resource isn't a model...
        if (!($resource instanceof Model)) {
            return null;
        }

        $updatedAtKey = $resource->getUpdatedAtColumn();
        return $resource[$updatedAtKey] ?? null;
    }

    /**
     * Prepares the Http Cache headers
     *
     * @param  array  $headers
     * @param \Illuminate\Http\Request  $request
     * @param \Illuminate\Http\JsonResponse $response
     *
     * @return array
     */
    protected function prepareCacheHeaders(array $headers, $request, $response): array
    {
        // Overwrite this method, if you require to adapt Http cache headers,
        // based on given request and response.

        return $headers;
    }
}
