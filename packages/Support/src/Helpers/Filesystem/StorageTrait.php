<?php

namespace Aedart\Support\Helpers\Filesystem;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

/**
 * Storage Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Filesystem\StorageAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Filesystem
 */
trait StorageTrait
{
    /**
     * Storage Disk instance
     *
     * @var Filesystem|null
     */
    protected Filesystem|null $storage = null;

    /**
     * Set storage
     *
     * @param Filesystem|null $disk Storage Disk instance
     *
     * @return self
     */
    public function setStorage(Filesystem|null $disk): static
    {
        $this->storage = $disk;

        return $this;
    }

    /**
     * Get storage
     *
     * If no storage has been set, this method will
     * set and return a default storage, if any such
     * value is available
     *
     * @see getDefaultStorage()
     *
     * @return Filesystem|null storage or null if none storage has been set
     */
    public function getStorage(): Filesystem|null
    {
        if (!$this->hasStorage()) {
            $this->setStorage($this->getDefaultStorage());
        }
        return $this->storage;
    }

    /**
     * Check if storage has been set
     *
     * @return bool True if storage has been set, false if not
     */
    public function hasStorage(): bool
    {
        return isset($this->storage);
    }

    /**
     * Get a default storage value, if any is available
     *
     * @return Filesystem|null A default storage value or Null if no default value is available
     */
    public function getDefaultStorage(): Filesystem|null
    {
        $manager = Storage::getFacadeRoot();
        if (isset($manager)) {
            return $manager->disk();
        }
        return $manager;
    }
}
