<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Storage path Aware
 *
 * Component is aware of string "storage path"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface StoragePathAware
{
    /**
     * Set storage path
     *
     * @param string|null $path Directory path where bootstrapping resources are located
     *
     * @return self
     */
    public function setStoragePath(string|null $path): static;

    /**
     * Get storage path
     *
     * If no storage path value set, method
     * sets and returns a default storage path.
     *
     * @see getDefaultStoragePath()
     *
     * @return string|null storage path or null if no storage path has been set
     */
    public function getStoragePath(): string|null;

    /**
     * Check if storage path has been set
     *
     * @return bool True if storage path has been set, false if not
     */
    public function hasStoragePath(): bool;

    /**
     * Get a default storage path value, if any is available
     *
     * @return string|null Default storage path value or null if no default value is available
     */
    public function getDefaultStoragePath(): string|null;
}
