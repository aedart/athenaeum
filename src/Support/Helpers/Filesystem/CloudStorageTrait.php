<?php

namespace Aedart\Support\Helpers\Filesystem;

use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Support\Facades\Storage;

/**
 * Cloud Storage Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Filesystem\CloudStorageAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Filesystem
 */
trait CloudStorageTrait
{
    /**
     * Cloud Storage Filesystem Disk instance
     *
     * @var Cloud|null
     */
    protected $cloudStorage = null;

    /**
     * Set cloud storage
     *
     * @param Cloud|null $disk Cloud Storage Filesystem Disk instance
     *
     * @return self
     */
    public function setCloudStorage(?Cloud $disk)
    {
        $this->cloudStorage = $disk;

        return $this;
    }

    /**
     * Get cloud storage
     *
     * If no cloud storage has been set, this method will
     * set and return a default cloud storage, if any such
     * value is available
     *
     * @see getDefaultCloudStorage()
     *
     * @return Cloud|null cloud storage or null if none cloud storage has been set
     */
    public function getCloudStorage(): ?Cloud
    {
        if (!$this->hasCloudStorage()) {
            $this->setCloudStorage($this->getDefaultCloudStorage());
        }
        return $this->cloudStorage;
    }

    /**
     * Check if cloud storage has been set
     *
     * @return bool True if cloud storage has been set, false if not
     */
    public function hasCloudStorage(): bool
    {
        return isset($this->cloudStorage);
    }

    /**
     * Get a default cloud storage value, if any is available
     *
     * @return Cloud|null A default cloud storage value or Null if no default value is available
     */
    public function getDefaultCloudStorage(): ?Cloud
    {
        $manager = Storage::getFacadeRoot();
        if (isset($manager)) {
            return $manager->disk();
        }
        return $manager;
    }
}
