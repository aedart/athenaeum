<?php

namespace Aedart\ETags\Preconditions\Rfc9110\Concerns;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Concerns Resource State Change
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Rfc9110\Concerns
 */
trait ResourceStateChange
{
    /**
     * Determines if resource already has successfully changed to a desired state
     * and aborts current request accordingly.
     *
     * @param  ResourceContext  $resource
     *
     * @return never
     *
     * @throws HttpExceptionInterface
     */
    protected function checkResourceStateChange(ResourceContext $resource)
    {
        // [...] if false, respond 412 (Precondition Failed) unless it can be determined that the
        // state-changing request has already succeeded [...]

        if (!$this->isSafeMethod() && $resource->hasStateChangeAlreadySucceeded($this->request())) {
            // [...]  if the request is a state-changing operation that appears to have already been
            // applied to the selected representation, the origin server MAY respond with a
            // 2xx (Successful) status code [...]
            $this->actions()->abortStateChangeAlreadySucceeded($resource);
        }

        // Otherwise, this is not a state-change request or no state change success could be determined.
        // Thus, we abort the request with a "precondition failed"
        $this->actions()->abortPreconditionFailed($resource);
    }
}
