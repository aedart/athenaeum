<?php

namespace Aedart\Contracts\Http\Messages;

use Psr\Http\Message\RequestInterface;

/**
 * Http Request Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages
 */
interface HttpRequestAware
{
    /**
     * Set http request
     *
     * @param  RequestInterface|null  $request  Http Request instance
     *
     * @return self
     */
    public function setHttpRequest(RequestInterface|null $request): static;

    /**
     * Get http request
     *
     * If no http request has been set, this method will
     * set and return a default http request, if any such
     * value is available
     *
     * @return RequestInterface|null http request or null if none http request has been set
     */
    public function getHttpRequest(): RequestInterface|null;

    /**
     * Check if http request has been set
     *
     * @return bool True if http request has been set, false if not
     */
    public function hasHttpRequest(): bool;

    /**
     * Get a default http request value, if any is available
     *
     * @return RequestInterface|null A default http request value or Null if no default value is available
     */
    public function getDefaultHttpRequest(): RequestInterface|null;
}
