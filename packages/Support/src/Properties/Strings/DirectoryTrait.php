<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Directory Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DirectoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DirectoryTrait
{
    /**
     * Path to a given directory, relative or absolute, existing or none-existing
     *
     * @var string|null
     */
    protected ?string $directory = null;

    /**
     * Set directory
     *
     * @param string|null $path Path to a given directory, relative or absolute, existing or none-existing
     *
     * @return self
     */
    public function setDirectory(?string $path)
    {
        $this->directory = $path;

        return $this;
    }

    /**
     * Get directory
     *
     * If no "directory" value set, method
     * sets and returns a default "directory".
     *
     * @see getDefaultDirectory()
     *
     * @return string|null directory or null if no directory has been set
     */
    public function getDirectory(): ?string
    {
        if (!$this->hasDirectory()) {
            $this->setDirectory($this->getDefaultDirectory());
        }
        return $this->directory;
    }

    /**
     * Check if "directory" has been set
     *
     * @return bool True if "directory" has been set, false if not
     */
    public function hasDirectory(): bool
    {
        return isset($this->directory);
    }

    /**
     * Get a default "directory" value, if any is available
     *
     * @return string|null Default "directory" value or null if no default value is available
     */
    public function getDefaultDirectory(): ?string
    {
        return null;
    }
}
