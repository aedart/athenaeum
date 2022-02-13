<?php

namespace Aedart\Contracts\Support\Helpers\Http;

use Illuminate\Http\Client\Factory;

/**
 * Http Client Factory Aware
 *
 * @see \Illuminate\Http\Client\Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Http
 */
interface ClientFactoryAware
{
    /**
     * Set client factory
     *
     * @param Factory|null $factory Http Client Factory
     *
     * @return self
     */
    public function setClientFactory(Factory|null $factory): static;

    /**
     * Get client factory
     *
     * If no client factory has been set, this method will
     * set and return a default client factory, if any such
     * value is available
     *
     * @return Factory|null client factory or null if none client factory has been set
     */
    public function getClientFactory(): Factory|null;

    /**
     * Check if client factory has been set
     *
     * @return bool True if client factory has been set, false if not
     */
    public function hasClientFactory(): bool;

    /**
     * Get a default client factory value, if any is available
     *
     * @return Factory|null A default client factory value or Null if no default value is available
     */
    public function getDefaultClientFactory(): Factory|null;
}
