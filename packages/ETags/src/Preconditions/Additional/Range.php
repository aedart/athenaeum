<?php

namespace Aedart\ETags\Preconditions\Additional;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\BasePrecondition;
use Aedart\ETags\Preconditions\Rfc9110\Concerns;

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
    use Concerns\RangeValidation;

    /**
     * @inheritDoc
     */
    public function isApplicable(ResourceContext $resource): bool
    {
        // x. When "Range" is requested, but without "If-Range" header, and "Range" is supported:
        // (Strictly speaking, this is NOT part of RFC9110's "13.2. Evaluation of Preconditions")

        // [...] A server MUST ignore a Range header field received with a request method that is unrecognized
        // or for which range handling is not defined. For this specification, GET is the only method for
        // which range handling is defined. [...]
        return $resource->supportsRangeRequest()
            && $this->getHeaders()->has('Range')
            && $this->getMethod() === 'GET';
    }

    /**
     * @inheritDoc
     */
    public function passes(ResourceContext $resource): bool
    {
        // At this point, the evaluator has a callback that can determine if "Range" is applicable.
        // The callback is responsible for validating the requested range(s). So, it is practical
        // to perform that validation here, to reduce possible duplicate logic elsewhere.
        return $this->isRangeApplicable($resource);
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