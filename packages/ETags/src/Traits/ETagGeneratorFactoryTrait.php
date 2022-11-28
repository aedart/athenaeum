<?php

namespace Aedart\ETags\Traits;

use Aedart\Contracts\ETags\Factory;
use Aedart\Support\Facades\IoCFacade;

/**
 * Etag Generator Factory Trait
 *
 * @see \Aedart\Contracts\ETags\ETagGeneratorFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Traits
 */
trait ETagGeneratorFactoryTrait
{
    /**
     * ETag Generator Factory instance
     *
     * @var Factory|null
     */
    protected Factory|null $etagGeneratorFactory = null;

    /**
     * Set etag generator factory
     *
     * @param  Factory|null  $factory  ETag Generator Factory instance
     *
     * @return self
     */
    public function setEtagGeneratorFactory(Factory|null $factory): static
    {
        $this->etagGeneratorFactory = $factory;

        return $this;
    }

    /**
     * Get etag generator factory
     *
     * If no etag generator factory has been set, this method will
     * set and return a default etag generator factory, if any such
     * value is available
     *
     * @return Factory|null etag generator factory or null if none etag generator factory has been set
     */
    public function getEtagGeneratorFactory(): Factory|null
    {
        if (!$this->hasEtagGeneratorFactory()) {
            $this->setEtagGeneratorFactory($this->getDefaultEtagGeneratorFactory());
        }
        return $this->etagGeneratorFactory;
    }

    /**
     * Check if etag generator factory has been set
     *
     * @return bool True if etag generator factory has been set, false if not
     */
    public function hasEtagGeneratorFactory(): bool
    {
        return isset($this->etagGeneratorFactory);
    }

    /**
     * Get a default etag generator factory value, if any is available
     *
     * @return Factory|null A default etag generator factory value or Null if no default value is available
     */
    public function getDefaultEtagGeneratorFactory(): Factory|null
    {
        return IoCFacade::tryMake(Factory::class);
    }
}