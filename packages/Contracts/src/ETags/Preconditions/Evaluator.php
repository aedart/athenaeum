<?php

namespace Aedart\Contracts\ETags\Preconditions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Request Preconditions Evaluator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions
 */
interface Evaluator extends
    HasRequest,
    HasPreconditions,
    HasActions
{
    /**
     * Evaluates request preconditions for given resource
     *
     * Method iterates through its list of request preconditions. If a precondition
     * is applicable (_via {@see Precondition::isApplicable()}_), then the precondition
     * is processed via {@see Precondition::process()}.
     *
     * @param  ResourceContext  $resource
     *
     * @return ResourceContext
     *
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    public function evaluate(ResourceContext $resource): ResourceContext;
}
