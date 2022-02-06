<?php

namespace Aedart\Contracts\Support\Helpers\Filesystem;

use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Storage Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Filesystem
 */
interface StorageAware
{
    /**
     * Set storage
     *
     * @param Filesystem|null $disk Storage Disk instance
     *
     * @return self
     */
    public function setStorage(Filesystem|null $disk): static;

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
    public function getStorage(): Filesystem|null;

    /**
     * Check if storage has been set
     *
     * @return bool True if storage has been set, false if not
     */
    public function hasStorage(): bool;

    /**
     * Get a default storage value, if any is available
     *
     * @return Filesystem|null A default storage value or Null if no default value is available
     */
    public function getDefaultStorage(): Filesystem|null;
}
