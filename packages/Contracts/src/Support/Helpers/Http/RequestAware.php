<?php

namespace Aedart\Contracts\Support\Helpers\Http;

/**
 * Request Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Http
 */
interface RequestAware
{
    /**
     * Set request
     *
     * @param \Illuminate\Http\Request|null $request Http Request instance
     *
     * @return self
     */
    public function setRequest($request): static;

    /**
     * Get request
     *
     * If no request has been set, this method will
     * set and return a default request, if any such
     * value is available
     *
     * @see getDefaultRequest()
     *
     * @return \Illuminate\Http\Request|null request or null if none request has been set
     */
    public function getRequest();

    /**
     * Check if request has been set
     *
     * @return bool True if request has been set, false if not
     */
    public function hasRequest(): bool;

    /**
     * Get a default request value, if any is available
     *
     * @return \Illuminate\Http\Request|null A default request value or Null if no default value is available
     */
    public function getDefaultRequest();
}
