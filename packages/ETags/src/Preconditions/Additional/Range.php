<?php

namespace Aedart\ETags\Preconditions\Additional;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\BasePrecondition;
use Aedart\ETags\Preconditions\Rfc9110\Concerns;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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
        // x. When "Range" is requested, but without "If-Range" header, and "Range" is supported.
        // Strictly speaking, this is NOT part of RFC9110's "13.2. Evaluation of Preconditions".
        // However, "Range" header must be processed when received, even without "If-Range".

        // [...] A server MUST ignore a Range header field received with a request method that is unrecognized
        // or for which range handling is not defined. For this specification, GET is the only method for
        // which range handling is defined. [...]
        $headers = $this->getHeaders();

        return $resource->supportsRangeRequest()
            && $headers->has('Range')
            && !$headers->has('If-Range')
            && $this->getMethod() === 'GET';
    }

    /**
     * {@inheritDoc}
     *
     * @throws HttpExceptionInterface
     */
    public function passes(ResourceContext $resource): bool
    {
        // At this point, the precondition can determine if "Range" is applicable. Doing so
        // allowed a developer to avoid having to manually validate it elsewhere in the application.
        return $this->isRangeApplicable($resource);
    }

    /**
     * @inheritDoc
     */
    public function whenPasses(ResourceContext $resource): ResourceContext|string|null
    {
        $this->actions()->processRange($resource, $this->getVerifiedRanges());

        // Allow evt. next precondition to be evaluated.
        return null;
    }

    /**
     * @inheritDoc
     */
    public function whenFails(ResourceContext $resource): ResourceContext|string|null
    {
        $this->actions()->ignoreRange($resource);

        // Allow evt. next precondition to be evaluated.
        return null;
    }
}
