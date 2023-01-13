<?php

namespace Aedart\Contracts\ETags;

/**
 * Etag Generator Factory Aware
 *
 * @see \Aedart\Contracts\ETags\Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags
 */
interface ETagGeneratorFactoryAware
{
    /**
     * Set etag generator factory
     *
     * @param  Factory|null  $factory  ETag Generator Factory instance
     *
     * @return self
     */
    public function setEtagGeneratorFactory(Factory|null $factory): static;

    /**
     * Get etag generator factory
     *
     * If no etag generator factory has been set, this method will
     * set and return a default etag generator factory, if any such
     * value is available
     *
     * @return Factory|null etag generator factory or null if none etag generator factory has been set
     */
    public function getEtagGeneratorFactory(): Factory|null;

    /**
     * Check if etag generator factory has been set
     *
     * @return bool True if etag generator factory has been set, false if not
     */
    public function hasEtagGeneratorFactory(): bool;

    /**
     * Get a default etag generator factory value, if any is available
     *
     * @return Factory|null A default etag generator factory value or Null if no default value is available
     */
    public function getDefaultEtagGeneratorFactory(): Factory|null;
}
