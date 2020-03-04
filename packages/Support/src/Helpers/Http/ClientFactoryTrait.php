<?php

namespace Aedart\Support\Helpers\Http;

use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Http;

/**
 * Http Client Factory Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Http\ClientFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Http
 */
trait ClientFactoryTrait
{
    /**
     * Http Client Factory
     *
     * @var Factory|null
     */
    protected ?Factory $clientFactory = null;

    /**
     * Set client factory
     *
     * @param Factory|null $factory Http Client Factory
     *
     * @return self
     */
    public function setClientFactory(?Factory $factory)
    {
        $this->clientFactory = $factory;

        return $this;
    }

    /**
     * Get client factory
     *
     * If no client factory has been set, this method will
     * set and return a default client factory, if any such
     * value is available
     *
     * @return Factory|null client factory or null if none client factory has been set
     */
    public function getClientFactory(): ?Factory
    {
        if (!$this->hasClientFactory()) {
            $this->setClientFactory($this->getDefaultClientFactory());
        }
        return $this->clientFactory;
    }

    /**
     * Check if client factory has been set
     *
     * @return bool True if client factory has been set, false if not
     */
    public function hasClientFactory(): bool
    {
        return isset($this->clientFactory);
    }

    /**
     * Get a default client factory value, if any is available
     *
     * @return Factory|null A default client factory value or Null if no default value is available
     */
    public function getDefaultClientFactory(): ?Factory
    {
        return Http::getFacadeRoot();
    }
}
