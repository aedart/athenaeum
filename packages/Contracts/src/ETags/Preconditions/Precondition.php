<?php

namespace Aedart\Contracts\ETags\Preconditions;

/**
 * Http Request Precondition
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Conditional_requests
 * @see https://httpwg.org/specs/rfc9110.html#preconditions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions
 */
interface Precondition
{
    /**
     * Returns unique string identifier of precondition
     *
     * @return string
     */
    public static function identifier(): string;

    /**
     * Determine if this precondition is applicable for evaluation
     *
     * @param  ResourceContext  $resource
     *
     * @return bool
     */
    public function isApplicable(ResourceContext $resource): bool;

    // TODO: .... only when is applicable
    public function evaluate(ResourceContext $resource);

    /**
     * Determine if this precondition passes or not
     *
     * @param  ResourceContext  $resource
     *
     * @return bool
     */
    public function passes(ResourceContext $resource): bool;
}