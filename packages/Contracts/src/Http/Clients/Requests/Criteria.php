<?php


namespace Aedart\Contracts\Http\Clients\Requests;

/**
 * Request Criteria
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests
 */
interface Criteria
{
    /**
     * Applies this criteria onto given request builder
     *
     * Method is intended to add additional constraints, scopes,
     * cookies, attachments or Http Query parameters for the
     * request that is about to be sent.
     *
     * Whether or not this "criteria" should be applied or not,
     * is entirely up to the actual implementation.
     *
     * @param Builder $request
     */
    public function apply(Builder $request): void;
}
