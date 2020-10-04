<?php

namespace Aedart\Http\Messages\Traits;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Http Server Request Trait
 *
 * @see \Aedart\Contracts\Http\Messages\HttpServerRequestAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Messages\Traits
 */
trait HttpServerRequestTrait
{
    /**
     * Http Server Request instance
     *
     * @var ServerRequestInterface|null
     */
    protected ?ServerRequestInterface $httpServerRequest = null;

    /**
     * Set http server request
     *
     * @param  ServerRequestInterface|null  $serverRequest  Http Server Request instance
     *
     * @return self
     */
    public function setHttpServerRequest(?ServerRequestInterface $serverRequest)
    {
        $this->httpServerRequest = $serverRequest;

        return $this;
    }

    /**
     * Get http server request
     *
     * If no http server request has been set, this method will
     * set and return a default http server request, if any such
     * value is available
     *
     * @return ServerRequestInterface|null http server request or null if none http server request has been set
     */
    public function getHttpServerRequest(): ?ServerRequestInterface
    {
        if (!$this->hasHttpServerRequest()) {
            $this->setHttpServerRequest($this->getDefaultHttpServerRequest());
        }
        return $this->httpServerRequest;
    }

    /**
     * Check if http server request has been set
     *
     * @return bool True if http server request has been set, false if not
     */
    public function hasHttpServerRequest(): bool
    {
        return isset($this->httpServerRequest);
    }

    /**
     * Get a default http server request value, if any is available
     *
     * @return ServerRequestInterface|null A default http server request value or Null if no default value is available
     */
    public function getDefaultHttpServerRequest(): ?ServerRequestInterface
    {
        return null;
    }
}
