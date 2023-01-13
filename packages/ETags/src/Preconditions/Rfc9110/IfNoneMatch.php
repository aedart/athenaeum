<?php

namespace Aedart\ETags\Preconditions\Rfc9110;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\BasePrecondition;

/**
 * If-None-Match precondition
 *
 * @see https://httpwg.org/specs/rfc9110.html#field.if-none-match
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Rfc9110
 */
class IfNoneMatch extends BasePrecondition
{
    /**
     * @inheritDoc
     */
    public function isApplicable(ResourceContext $resource): bool
    {
        // 3. When If-None-Match is present, [...]:
        return $this->getHeaders()->has('If-None-Match');
    }

    /**
     * @inheritDoc
     */
    public function passes(ResourceContext $resource): bool
    {
        $ifNoneMatchCollection = $this->getIfNoneMatchEtags();

        // [...] If the field value is "*", the condition is FALSE if the origin server has a current representation for the target resource.
        // [...] If the field value is a list of entity tags, the condition is FALSE if one of the listed tags matches the entity tag of the selected representation.
        // [...] A recipient MUST use the weak comparison [...] for If-None-Match
        if ($resource->hasEtag() && $ifNoneMatchCollection->contains($resource->etag(), false)) {
            return false;
        }

        // Otherwise, the condition is true.
        return true;
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
        // [...] if false for GET/HEAD, respond 304 (Not Modified)
        if (in_array($this->getMethod(), ['GET', 'HEAD'])) {
            $this->actions()->abortNotModified($resource);
        }

        // [...] if false for other methods, respond 412 (Precondition Failed)
        $this->actions()->abortPreconditionFailed($resource);
    }
}
