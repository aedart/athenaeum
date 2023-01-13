<?php

namespace Aedart\ETags\Preconditions\Rfc9110;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\BasePrecondition;

/**
 * If-Match precondition
 *
 * @see https://httpwg.org/specs/rfc9110.html#field.if-match
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Rfc9110
 */
class IfMatch extends BasePrecondition
{
    use Concerns\ResourceStateChange;

    /**
     * @inheritDoc
     */
    public function isApplicable(ResourceContext $resource): bool
    {
        // 1. When recipient is the origin server and If-Match is present, [...]:
        return $this->getHeaders()->has('If-Match');
    }

    /**
     * @inheritDoc
     */
    public function passes(ResourceContext $resource): bool
    {
        $ifMatchCollection = $this->getIfMatchEtags();

        // An origin server MUST use the strong comparison [...] for If-Match
        if ($resource->hasEtag()
            && $ifMatchCollection->isNotEmpty()
            && $ifMatchCollection->contains($resource->etag(), true)
        ) {
            return true;
        }

        // This means either that there is no current representation of the resource,
        // or that requested etag(s) do not match the etag of the resource.
        return false;
    }

    /**
     * @inheritDoc
     */
    public function whenPasses(ResourceContext $resource): ResourceContext|string
    {
        // [...] if true, continue to step 3 (If-None-Match)
        return IfNoneMatch::class;
    }

    /**
     * @inheritDoc
     */
    public function whenFails(ResourceContext $resource): ResourceContext|string
    {
        // Abort the request appropriately...
        $this->checkResourceStateChange($resource);
    }
}
