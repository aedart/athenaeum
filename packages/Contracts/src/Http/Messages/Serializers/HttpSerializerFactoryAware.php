<?php

namespace Aedart\Contracts\Http\Messages\Serializers;

/**
 * Http Serializer Factory Aware
 *
 * @see \Aedart\Contracts\Http\Messages\Serializers\Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages\Serializers
 */
interface HttpSerializerFactoryAware
{
    /**
     * Set http serializer factory
     *
     * @param  Factory|null  $factory  Http Message Serializer Factory instance
     *
     * @return self
     */
    public function setHttpSerializerFactory(?Factory $factory);

    /**
     * Get http serializer factory
     *
     * If no http serializer factory has been set, this method will
     * set and return a default http serializer factory, if any such
     * value is available
     *
     * @return Factory|null http serializer factory or null if none http serializer factory has been set
     */
    public function getHttpSerializerFactory(): ?Factory;

    /**
     * Check if http serializer factory has been set
     *
     * @return bool True if http serializer factory has been set, false if not
     */
    public function hasHttpSerializerFactory(): bool;

    /**
     * Get a default http serializer factory value, if any is available
     *
     * @return Factory|null A default http serializer factory value or Null if no default value is available
     */
    public function getDefaultHttpSerializerFactory(): ?Factory;
}
