<?php

namespace Aedart\ETags\Preconditions\Rfc9110;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\BasePrecondition;

/**
 * If-Unmodified-Since precondition
 *
 * @see https://httpwg.org/specs/rfc9110.html#field.if-unmodified-since
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Rfc9110
 */
class IfUnmodifiedSince extends BasePrecondition
{
    use Concerns\ResourceStateChange;

    /**
     * @inheritDoc
     */
    public function isApplicable(ResourceContext $resource): bool
    {
        // 2. When recipient is the origin server, If-Match is not present, and If-Unmodified-Since is present, [...]:
        $headers = $this->getHeaders();
        return $resource->hasLastModifiedDate() && $headers->has('If-Unmodified-Since') && !$headers->has('If-Match');
    }

    /**
     * @inheritDoc
     */
    public function passes(ResourceContext $resource): bool
    {
        $ifUnmodifiedSince = $this->getIfUnmodifiedSinceDate();
        if (!isset($ifUnmodifiedSince)) {
            return false;
        }

        // [...] If the selected representation's last modification date is earlier than or equal to
        // the date provided in the field value, the condition is TRUE. [...]
        return $this->resolveLastModifiedDate($resource)->lessThanOrEqualTo($ifUnmodifiedSince);
    }

    /**
     * @inheritDoc
     */
    public function whenPasses(ResourceContext $resource): ResourceContext|string|null
    {
        // [...] if true, continue to step 3 (If-None-Match)
        return IfNoneMatch::class;
    }

    /**
     * @inheritDoc
     */
    public function whenFails(ResourceContext $resource): ResourceContext|string|null
    {
        // Abort the request appropriately...
        $this->checkResourceStateChange($resource);
    }
}
