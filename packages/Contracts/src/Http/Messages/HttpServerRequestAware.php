<?php

namespace Aedart\Contracts\Http\Messages;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Http Server Request Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages
 */
interface HttpServerRequestAware
{
    /**
     * Set http server request
     *
     * @param  ServerRequestInterface|null  $serverRequest  Http Server Request instance
     *
     * @return self
     */
    public function setHttpServerRequest(?ServerRequestInterface $serverRequest);

    /**
     * Get http server request
     *
     * If no http server request has been set, this method will
     * set and return a default http server request, if any such
     * value is available
     *
     * @return ServerRequestInterface|null http server request or null if none http server request has been set
     */
    public function getHttpServerRequest(): ?ServerRequestInterface;

    /**
     * Check if http server request has been set
     *
     * @return bool True if http server request has been set, false if not
     */
    public function hasHttpServerRequest(): bool;

    /**
     * Get a default http server request value, if any is available
     *
     * @return ServerRequestInterface|null A default http server request value or Null if no default value is available
     */
    public function getDefaultHttpServerRequest(): ?ServerRequestInterface;
}
