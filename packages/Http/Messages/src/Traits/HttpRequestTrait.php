<?php

namespace Aedart\Http\Messages\Traits;

use Psr\Http\Message\RequestInterface;

/**
 * Http Request Trait
 *
 * @see \Aedart\Contracts\Http\Messages\HttpRequestAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Messages\Traits
 */
trait HttpRequestTrait
{
    /**
     * Http Request instance
     *
     * @var RequestInterface|null
     */
    protected RequestInterface|null $httpRequest = null;

    /**
     * Set http request
     *
     * @param  RequestInterface|null  $request  Http Request instance
     *
     * @return self
     */
    public function setHttpRequest(RequestInterface|null $request): static
    {
        $this->httpRequest = $request;

        return $this;
    }

    /**
     * Get http request
     *
     * If no http request has been set, this method will
     * set and return a default http request, if any such
     * value is available
     *
     * @return RequestInterface|null http request or null if none http request has been set
     */
    public function getHttpRequest(): RequestInterface|null
    {
        if (!$this->hasHttpRequest()) {
            $this->setHttpRequest($this->getDefaultHttpRequest());
        }
        return $this->httpRequest;
    }

    /**
     * Check if http request has been set
     *
     * @return bool True if http request has been set, false if not
     */
    public function hasHttpRequest(): bool
    {
        return isset($this->httpRequest);
    }

    /**
     * Get a default http request value, if any is available
     *
     * @return RequestInterface|null A default http request value or Null if no default value is available
     */
    public function getDefaultHttpRequest(): RequestInterface|null
    {
        return null;
    }
}
