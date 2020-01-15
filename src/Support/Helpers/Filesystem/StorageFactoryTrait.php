<?php

namespace Aedart\Support\Helpers\Filesystem;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * Storage Factory Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Filesystem\StorageFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Filesystem
 */
trait StorageFactoryTrait
{
    /**
     * Cloud Storage Factory instance
     *
     * @var Factory|null
     */
    protected ?Factory $storageFactory = null;

    /**
     * Set storage factory
     *
     * @param Factory|null $factory Cloud Storage Factory instance
     *
     * @return self
     */
    public function setStorageFactory(?Factory $factory)
    {
        $this->storageFactory = $factory;

        return $this;
    }

    /**
     * Get storage factory
     *
     * If no storage factory has been set, this method will
     * set and return a default storage factory, if any such
     * value is available
     *
     * @see getDefaultStorageFactory()
     *
     * @return Factory|null storage factory or null if none storage factory has been set
     */
    public function getStorageFactory(): ?Factory
    {
        if (!$this->hasStorageFactory()) {
            $this->setStorageFactory($this->getDefaultStorageFactory());
        }
        return $this->storageFactory;
    }

    /**
     * Check if storage factory has been set
     *
     * @return bool True if storage factory has been set, false if not
     */
    public function hasStorageFactory(): bool
    {
        return isset($this->storageFactory);
    }

    /**
     * Get a default storage factory value, if any is available
     *
     * @return Factory|null A default storage factory value or Null if no default value is available
     */
    public function getDefaultStorageFactory(): ?Factory
    {
        return Storage::getFacadeRoot();
    }
}
