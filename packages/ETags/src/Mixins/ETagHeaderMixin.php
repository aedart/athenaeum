<?php

namespace Aedart\ETags\Mixins;

use Aedart\Contracts\ETags\ETag as ETagInterface;
use Aedart\ETags\ETag;
use Closure;

/**
 * Etag Header Mixin
 *
 * Mixin is intended for Laravel's {@see \Illuminate\Http\Response}
 *
 * @mixin \Illuminate\Http\Response
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Mixins
 */
class ETagHeaderMixin
{
    /**
     * Set the ETag Http Header
     *
     * @param  ETagInterface|string|null  $eTag  [optional]
     *
     * @return Closure
     */
    public function withEtag(ETagInterface|string|null $eTag = null): Closure
    {
        return function(ETagInterface|string|null $eTag = null) {
            // Remove ETag header if null given...
            if (!isset($eTag)) {
                return $this->setEtag(null);
            }

            if (is_string($eTag)) {
                $eTag = ETag::parse($eTag);
            }

            return $this->setEtag($eTag->raw(), $eTag->isWeak());
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
}