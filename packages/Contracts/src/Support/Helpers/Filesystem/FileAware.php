<?php

namespace Aedart\Contracts\Support\Helpers\Filesystem;

/**
 * File Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Filesystem
 */
interface FileAware
{
    /**
     * Set file
     *
     * @param \Illuminate\Filesystem\Filesystem|null $filesystem Filesystem instance
     *
     * @return self
     */
    public function setFile($filesystem): static;

    /**
     * Get file
     *
     * If no file has been set, this method will
     * set and return a default file, if any such
     * value is available
     *
     * @see getDefaultFile()
     *
     * @return \Illuminate\Filesystem\Filesystem|null file or null if none file has been set
     */
    public function getFile();

    /**
     * Check if file has been set
     *
     * @return bool True if file has been set, false if not
     */
    public function hasFile(): bool;

    /**
     * Get a default file value, if any is available
     *
     * @return \Illuminate\Filesystem\Filesystem|null A default file value or Null if no default value is available
     */
    public function getDefaultFile();
}
