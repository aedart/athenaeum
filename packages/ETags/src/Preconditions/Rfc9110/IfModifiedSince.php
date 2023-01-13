<?php

namespace Aedart\ETags\Preconditions\Rfc9110;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\BasePrecondition;
use Illuminate\Support\Carbon;

/**
 * If-Modified-Since precondition
 *
 * @see https://httpwg.org/specs/rfc9110.html#field.if-modified-since
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Rfc9110
 */
class IfModifiedSince extends BasePrecondition
{
    /**
     * @inheritDoc
     */
    public function isApplicable(ResourceContext $resource): bool
    {
        // 4. When the method is GET or HEAD, If-None-Match is not present, and If-Modified-Since is present, [...]:
        $headers = $this->getHeaders();
        return $resource->hasLastModifiedDate()
            && $headers->has('If-Modified-Since')
            && !$headers->has('If-None-Match')
            && in_array($this->getMethod(), ['GET', 'HEAD']);
    }

    /**
     * @inheritDoc
     */
    public function passes(ResourceContext $resource): bool
    {
        $ifModifiedSince = $this->getIfModifiedSinceDate();
        if (!isset($ifModifiedSince)) {
            return true;
        }

        // [...] If the selected representation's last modification date is earlier or equal to
        // the date provided in the field value, the condition is FALSE. [...]
        return !Carbon::instance($resource->lastModifiedDate())->lessThanOrEqualTo($ifModifiedSince);
    }

    /**
     * @inheritDoc
     */
    public function whenPasses(ResourceContext $resource): ResourceContext|string
    {
        // [...] if true, continue to step 5 (If-Range)
        return IfRange::class;
    }

    /**
     * @inheritDoc
     */
    public function whenFails(ResourceContext $resource): ResourceContext|string
    {
        // [...] if false, respond 304 (Not Modified)
        $this->actions()->abortNotModified($resource);
    }
}
