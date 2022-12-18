<?php

namespace Aedart\ETags\Preconditions\Additional;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\BasePrecondition;

/**
 * Range precondition
 *
 * @see https://httpwg.org/specs/rfc9110.html#field.range
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Extensions
 */
class Range extends BasePrecondition
{
    /**
     * @inheritDoc
     */
    public function isApplicable(ResourceContext $resource): bool
    {
        // x. When "Range" is requested, but without "If-Range" header, and "Range" is supported:
        // (Strictly speaking, this is NOT part of RFC9110's "13.2. Evaluation of Preconditions")
        return $resource->supportsRangeRequest()
            && $this->getHeaders()->has('Range')
            && $this->getMethod() === 'GET';
    }

    /**
     * @inheritDoc
     */
    public function passes(ResourceContext $resource): bool
    {
        // TODO: THIS MUST SOMEHOW BE IMPLEMENTED! PERHAPS VIA THE RESOURCE ?
        // TODO: ...also change the description of this...
        // At this point, the evaluator has a callback that can determine if "Range" is applicable.
        // The callback is responsible for validating the requested range(s). So, it is practical
        // to perform that validation here, to reduce possible duplicate logic elsewhere.
        return $this->isRangeApplicable();
    }

    /**
     * @inheritDoc
     */
    public function whenPasses(ResourceContext $resource): ResourceContext|string
    {
        return $this->actions()->processRangeHeader($resource);
    }

    /**
     * @inheritDoc
     */
    public function whenFails(ResourceContext $resource): ResourceContext|string
    {
        // TODO: Uhm... should request be aborted,... or just ignore "Range" ?
        return $this->actions()->ignoreRangeHeader($resource);
    }
}