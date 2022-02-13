<?php

namespace Aedart\Http\Messages\Traits;

use Aedart\Contracts\Http\Messages\Serializers\Factory;
use Aedart\Support\Facades\IoCFacade;

/**
 * Http Serializer Factory Trait
 *
 * @see \Aedart\Contracts\Http\Messages\Serializers\HttpSerializerFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Messages\Traits
 */
trait HttpSerializerFactoryTrait
{
    /**
     * Http Message Serializer Factory instance
     *
     * @var Factory|null
     */
    protected Factory|null $httpSerializerFactory = null;

    /**
     * Set http serializer factory
     *
     * @param  Factory|null  $factory  Http Message Serializer Factory instance
     *
     * @return self
     */
    public function setHttpSerializerFactory(Factory|null $factory): static
    {
        $this->httpSerializerFactory = $factory;

        return $this;
    }

    /**
     * Get http serializer factory
     *
     * If no http serializer factory has been set, this method will
     * set and return a default http serializer factory, if any such
     * value is available
     *
     * @return Factory|null http serializer factory or null if none http serializer factory has been set
     */
    public function getHttpSerializerFactory(): Factory|null
    {
        if (!$this->hasHttpSerializerFactory()) {
            $this->setHttpSerializerFactory($this->getDefaultHttpSerializerFactory());
        }
        return $this->httpSerializerFactory;
    }

    /**
     * Check if http serializer factory has been set
     *
     * @return bool True if http serializer factory has been set, false if not
     */
    public function hasHttpSerializerFactory(): bool
    {
        return isset($this->httpSerializerFactory);
    }

    /**
     * Get a default http serializer factory value, if any is available
     *
     * @return Factory|null A default http serializer factory value or Null if no default value is available
     */
    public function getDefaultHttpSerializerFactory(): Factory|null
    {
        return IoCFacade::tryMake(Factory::class);
    }
}
