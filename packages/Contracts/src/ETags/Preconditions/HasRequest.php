<?php

namespace Aedart\Contracts\ETags\Preconditions;

/**
 * Has Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions
 */
interface HasRequest
{
    /**
     * Set the request
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return self
     */
    public function setRequest($request): static;

    /**
     * Get the request
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest();

    /**
     * Alias for {@see getRequest()}
     *
     * @return Illuminate\Http\Request
     */
    public function request();
}