<?php

namespace Aedart\Http\Clients\Traits;

use Aedart\Contracts\Http\Clients\Client;

/**
 * Http Client Trait
 *
 * @see \Aedart\Contracts\Http\Clients\HttpClientAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Traits
 */
trait HttpClientTrait
{
    /**
     * Http Client
     *
     * @var Client|null
     */
    protected ?Client $httpClient = null;

    /**
     * Set http client
     *
     * @param Client|null $client Http Client
     *
     * @return self
     */
    public function setHttpClient(?Client $client)
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Get http client
     *
     * If no http client has been set, this method will
     * set and return a default http client, if any such
     * value is available
     *
     * @return Client|null http client or null if none http client has been set
     */
    public function getHttpClient(): ?Client
    {
        if (!$this->hasHttpClient()) {
            $this->setHttpClient($this->getDefaultHttpClient());
        }
        return $this->httpClient;
    }

    /**
     * Check if http client has been set
     *
     * @return bool True if http client has been set, false if not
     */
    public function hasHttpClient(): bool
    {
        return isset($this->httpClient);
    }

    /**
     * Get a default http client value, if any is available
     *
     * @return Client|null A default http client value or Null if no default value is available
     */
    public function getDefaultHttpClient(): ?Client
    {
        return null;
    }
}
