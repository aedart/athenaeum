<?php

namespace Aedart\ETags\Preconditions;

use Aedart\Contracts\ETags\Preconditions\Precondition;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;

/**
 * Request Preconditions Evaluator
 *
 * TODO: Interface?
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions
 */
class Evaluator
{

    // TODO: ...
    public function evaluate(ResourceContext $resource)
    {
        $preconditions = $this->getPreconditions();


        if (empty($preconditions)) {
            // TODO: What if no preconditions are given...
        }

        // Get initial request precondition
        $precondition = array_shift($preconditions);

        while($precondition !== null) {

            // TODO: Prepare precondition, e.g. set request, actions... etc

            if ($precondition->isApplicable($resource)) {
                // TODO: Then what... if evaluate aborts request, sure... but how do we change
                // TODO: to another or next precondition...
                $precondition->evaluate($resource);
            }

            // Continue to next
            $precondition = array_shift($preconditions);
        }

        // TODO: What to do when all completed?
    }

    /**
     * Returns all preconditions to evaluate if applicable
     *
     * @return Precondition[] Key-value pair, key = identifier, value = Precondition
     */
    public function getPreconditions(): array
    {
        return [];
    }

    // TODO: A way to set / specify request preconditions...
}