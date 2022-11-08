<?php

namespace Aedart\ETags\Mixins;

use Aedart\Contracts\ETags\ETag;
use Aedart\ETags\Facades\Generator;
use Closure;
use DateTimeInterface;
use Illuminate\Support\Carbon;

/**
 * Response Etags Mixin
 *
 * Mixin is intended for Laravel's {@see \Illuminate\Http\Response}
 *
 * @mixin \Illuminate\Http\Response
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Mixins
 */
class ResponseETagsMixin
{
    /**
     * Set the ETag Http Header
     *
     * @return Closure
     */
    public function withEtag(): Closure
    {
        return function(ETag|string|null $etag = null) {
            // Remove ETag header if null given...
            if (!isset($etag)) {
                return $this->setEtag(null);
            }

            if (is_string($etag)) {
                $etag = Generator::parseSingle($etag);
            }

            return $this->setEtag($etag->raw(), $etag->isWeak());
        };
    }

    /**
     * Remove the ETag Http Header
     *
     * @return Closure
     */
    public function withoutEtag(): Closure
    {
        return function() {
            return $this->setEtag(null);
        };
    }

    /**
     * Set the response's cache headers
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cache-Control
     *
     * @return Closure
     */
    public function withCache(): Closure
    {
        // @see \Symfony\Component\HttpFoundation\Response::setCache

        return function(
            ETag|string|null $etag = null,
            string|DateTimeInterface|null $lastModified = null,
            int|null $maxAge = null,
            int|null $sharedMaxAge = null,
            bool $public = false,
            bool $private = false,
            bool $mustRevalidate = false,
            bool $noCache = false,
            bool $noStore = false,
            bool $noTransform = false,
            bool $proxyRevalidate = false,
            bool $immutable = false,
        ) {
            // Set Etag via "with Etag", because Symfony's setCache method
            // does not allow specifying if etag is weak or not...
            $this->withEtag($etag);

            // Resolve evt. last modified date
            $lastModified = is_string($lastModified)
                ? Carbon::make($lastModified)
                : $lastModified;

            // Apply remaining cache headers...
            return $this->setCache([
                'must_revalidate' => $mustRevalidate,
                'no_cache' => $noCache,
                'no_store' => $noStore,
                'no_transform' => $noTransform,
                'public' => $public,
                'private' => $private,
                'proxy_revalidate' => $proxyRevalidate,
                'max_age' => $maxAge,
                's_maxage' => $sharedMaxAge,
                'immutable' => $immutable,
                'last_modified' => $lastModified,
            ]);
        };
    }
}