<?php

namespace Aedart\Contracts\Http\Clients;

/**
 * Http Client Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients
 */
interface HttpClientAware
{
    /**
     * Set http client
     *
     * @param Client|null $client Http Client
     *
     * @return self
     */
    public function setHttpClient(?Client $client);

    /**
     * Get http client
     *
     * If no http client has been set, this method will
     * set and return a default http client, if any such
     * value is available
     *
     * @return Client|null http client or null if none http client has been set
     */
    public function getHttpClient(): ?Client;

    /**
     * Check if http client has been set
     *
     * @return bool True if http client has been set, false if not
     */
    public function hasHttpClient(): bool;

    /**
     * Get a default http client value, if any is available
     *
     * @return Client|null A default http client value or Null if no default value is available
     */
    public function getDefaultHttpClient(): ?Client;
}
