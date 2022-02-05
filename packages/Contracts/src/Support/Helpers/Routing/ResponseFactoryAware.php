<?php

namespace Aedart\Contracts\Support\Helpers\Routing;

use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Response Factory Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Routing
 */
interface ResponseFactoryAware
{
    /**
     * Set response factory
     *
     * @param ResponseFactory|null $factory Response Factory instance
     *
     * @return self
     */
    public function setResponseFactory(ResponseFactory|null $factory): static;

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
    public function getResponseFactory(): ResponseFactory|null;

    /**
     * Check if response factory has been set
     *
     * @return bool True if response factory has been set, false if not
     */
    public function hasResponseFactory(): bool;

    /**
     * Get a default response factory value, if any is available
     *
     * @return ResponseFactory|null A default response factory value or Null if no default value is available
     */
    public function getDefaultResponseFactory(): ResponseFactory|null;
}
