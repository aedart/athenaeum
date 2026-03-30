<?php

namespace Aedart\Contracts\ETags\Preconditions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Http Request Precondition
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Conditional_requests
 * @see https://httpwg.org/specs/rfc9110.html#preconditions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions
 */
interface Precondition extends
    HasRequest,
    HasActions
{
    /**
     * Determine if this precondition is applicable for evaluation
     *
     * @param  ResourceContext  $resource
     *
     * @return bool
     */
    public function isApplicable(ResourceContext $resource): bool;

    /**
     * Evaluates this precondition via {@see passes()} and takes appropriate
     * action if it passes or fails.
     *
     * This method SHOULD only be invoked if {@see isApplicable()} returns `true`.
     *
     * @param  ResourceContext  $resource
     *
     * @return ResourceContext|class-string<Precondition>|null Class path to another precondition to be evaluated,
     *                                     null if evaluator should continue to next precondition, or
     *                                     {@see ResourceContext} when request should proceed
     *                                     (stop evaluation of other preconditions).
     *
     * @throws HttpExceptionInterface
     */
    public function process(ResourceContext $resource): ResourceContext|string|null;

    /**
     * Determine if this precondition passes or not
     *
     * @param  ResourceContext  $resource
     *
     * @return bool
     */
    public function passes(ResourceContext $resource): bool;
}
