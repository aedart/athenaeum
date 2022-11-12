<?php

namespace Aedart\ETags\Mixins;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\Exceptions\ETagException;
use Aedart\ETags\Facades\Generator;
use Closure;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Request Etags Mixin
 *
 * Mixin is intended for Laravel's {@see \Illuminate\Http\Request}
 *
 * @mixin \Illuminate\Http\Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Mixins
 */
class RequestETagsMixin
{
    /**
     * Get a collection of etags from given header
     *
     * @return Closure
     */
    public function etagsFrom(): Closure
    {
        return function(string $header): Collection
        {
            try {
                return Generator::parse($this->header($header, ''));
            } catch (ETagException $e) {
                throw new BadRequestHttpException(sprintf('Invalid etag value(s) in %s header', $header), $e);
            }
        };
    }

    /**
     * Get collection of etags from the If-Match header
     *
     * @return Closure
     */
    public function ifMatchEtags(): Closure
    {
        return function(): Collection
        {
            return $this->etagsFrom('If-Match');
        };
    }

    /**
     * Get collection of etags from the If-None-Match header
     *
     * @return Closure
     */
    public function ifNoneMatchEtags(): Closure
    {
        return function(): Collection
        {
            return $this->etagsFrom('If-None-Match');
        };
    }
}