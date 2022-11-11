<?php

namespace Aedart\ETags\Mixins;

use Aedart\Contracts\ETags\Collection;
use Aedart\ETags\Facades\Generator;
use Closure;

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
            return Generator::parse(
                $this->header($header, '')
            );
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