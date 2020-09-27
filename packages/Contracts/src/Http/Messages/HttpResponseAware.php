<?php

namespace Aedart\Contracts\Http\Messages;

use Psr\Http\Message\ResponseInterface;

/**
 * Http Response Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages
 */
interface HttpResponseAware
{
    /**
     * Set http response
     *
     * @param  ResponseInterface|null  $response  Http Response instance
     *
     * @return self
     */
    public function setHttpResponse(?ResponseInterface $response);

    /**
     * Get http response
     *
     * If no http response has been set, this method will
     * set and return a default http response, if any such
     * value is available
     *
     * @return ResponseInterface|null http response or null if none http response has been set
     */
    public function getHttpResponse(): ?ResponseInterface;

    /**
     * Check if http response has been set
     *
     * @return bool True if http response has been set, false if not
     */
    public function hasHttpResponse(): bool;

    /**
     * Get a default http response value, if any is available
     *
     * @return ResponseInterface|null A default http response value or Null if no default value is available
     */
    public function getDefaultHttpResponse(): ?ResponseInterface;
}
