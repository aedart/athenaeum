<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Storage path Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\StoragePathAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait StoragePathTrait
{
    /**
     * Directory path where bootstrapping resources are located
     *
     * @var string|null
     */
    protected string|null $storagePath = null;

    /**
     * Set storage path
     *
     * @param string|null $path Directory path where bootstrapping resources are located
     *
     * @return self
     */
    public function setStoragePath(string|null $path): static
    {
        $this->storagePath = $path;

        return $this;
    }

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
    public function getStoragePath(): string|null
    {
        if (!$this->hasStoragePath()) {
            $this->setStoragePath($this->getDefaultStoragePath());
        }
        return $this->storagePath;
    }

    /**
     * Check if storage path has been set
     *
     * @return bool True if storage path has been set, false if not
     */
    public function hasStoragePath(): bool
    {
        return isset($this->storagePath);
    }

    /**
     * Get a default storage path value, if any is available
     *
     * @return string|null Default storage path value or null if no default value is available
     */
    public function getDefaultStoragePath(): string|null
    {
        return null;
    }
}
