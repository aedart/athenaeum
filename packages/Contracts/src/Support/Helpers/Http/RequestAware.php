<?php

namespace Aedart\Contracts\Support\Helpers\Http;

use Illuminate\Http\Request;

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
     * @param Request|null $request Http Request instance
     *
     * @return self
     */
    public function setRequest(?Request $request);

    /**
     * Get request
     *
     * If no request has been set, this method will
     * set and return a default request, if any such
     * value is available
     *
     * @see getDefaultRequest()
     *
     * @return Request|null request or null if none request has been set
     */
    public function getRequest(): ?Request;

    /**
     * Check if request has been set
     *
     * @return bool True if request has been set, false if not
     */
    public function hasRequest(): bool;

    /**
     * Get a default request value, if any is available
     *
     * @return Request|null A default request value or Null if no default value is available
     */
    public function getDefaultRequest(): ?Request;
}
