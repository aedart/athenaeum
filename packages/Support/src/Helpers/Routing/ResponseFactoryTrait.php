<?php

namespace Aedart\Support\Helpers\Routing;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Response;

/**
 * Response Factory Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Routing\ResponseFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Routing
 */
trait ResponseFactoryTrait
{
    /**
     * Response Factory instance
     *
     * @var ResponseFactory|null
     */
    protected ResponseFactory|null $responseFactory = null;

    /**
     * Set response factory
     *
     * @param ResponseFactory|null $factory Response Factory instance
     *
     * @return self
     */
    public function setResponseFactory(ResponseFactory|null $factory): static
    {
        $this->responseFactory = $factory;

        return $this;
    }

    /**
     * Get response factory
     *
     * If no response factory has been set, this method will
     * set and return a default response factory, if any such
     * value is available
     *
     * @see getDefaultResponseFactory()
     *
     * @return ResponseFactory|null response factory or null if none response factory has been set
     */
    public function getResponseFactory(): ResponseFactory|null
    {
        if (!$this->hasResponseFactory()) {
            $this->setResponseFactory($this->getDefaultResponseFactory());
        }
        return $this->responseFactory;
    }

    /**
     * Check if response factory has been set
     *
     * @return bool True if response factory has been set, false if not
     */
    public function hasResponseFactory(): bool
    {
        return isset($this->responseFactory);
    }

    /**
     * Get a default response factory value, if any is available
     *
     * @return ResponseFactory|null A default response factory value or Null if no default value is available
     */
    public function getDefaultResponseFactory(): ResponseFactory|null
    {
        return Response::getFacadeRoot();
    }
}
