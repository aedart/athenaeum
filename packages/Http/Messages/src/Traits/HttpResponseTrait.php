<?php

namespace Aedart\Http\Messages\Traits;

use Psr\Http\Message\ResponseInterface;

/**
 * Http Response Trait
 *
 * @see \Aedart\Contracts\Http\Messages\HttpResponseAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Messages\Traits
 */
trait HttpResponseTrait
{
    /**
     * Http Response instance
     *
     * @var ResponseInterface|null
     */
    protected ResponseInterface|null $httpResponse = null;

    /**
     * Set http response
     *
     * @param  ResponseInterface|null  $response  Http Response instance
     *
     * @return self
     */
    public function setHttpResponse(ResponseInterface|null $response): static
    {
        $this->httpResponse = $response;

        return $this;
    }

    /**
     * Get http response
     *
     * If no http response has been set, this method will
     * set and return a default http response, if any such
     * value is available
     *
     * @return ResponseInterface|null http response or null if none http response has been set
     */
    public function getHttpResponse(): ResponseInterface|null
    {
        if (!$this->hasHttpResponse()) {
            $this->setHttpResponse($this->getDefaultHttpResponse());
        }
        return $this->httpResponse;
    }

    /**
     * Check if http response has been set
     *
     * @return bool True if http response has been set, false if not
     */
    public function hasHttpResponse(): bool
    {
        return isset($this->httpResponse);
    }

    /**
     * Get a default http response value, if any is available
     *
     * @return ResponseInterface|null A default http response value or Null if no default value is available
     */
    public function getDefaultHttpResponse(): ResponseInterface|null
    {
        return null;
    }
}
