<?php

namespace Aedart\Support\Helpers\Filesystem;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

/**
 * File Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Filesystem\FileAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Filesystem
 */
trait FileTrait
{
    /**
     * Filesystem instance
     *
     * @var Filesystem|null
     */
    protected ?Filesystem $file = null;

    /**
     * Set file
     *
     * @param Filesystem|null $filesystem Filesystem instance
     *
     * @return self
     */
    public function setFile(?Filesystem $filesystem)
    {
        $this->file = $filesystem;

        return $this;
    }

    /**
     * Get file
     *
     * If no file has been set, this method will
     * set and return a default file, if any such
     * value is available
     *
     * @see getDefaultFile()
     *
     * @return Filesystem|null file or null if none file has been set
     */
    public function getFile(): ?Filesystem
    {
        if (!$this->hasFile()) {
            $this->setFile($this->getDefaultFile());
        }
        return $this->file;
    }

    /**
     * Check if file has been set
     *
     * @return bool True if file has been set, false if not
     */
    public function hasFile(): bool
    {
        return isset($this->file);
    }

    /**
     * Get a default file value, if any is available
     *
     * @return Filesystem|null A default file value or Null if no default value is available
     */
    public function getDefaultFile(): ?Filesystem
    {
        return File::getFacadeRoot();
    }
}
