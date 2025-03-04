<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * File path Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\FilePathAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait FilePathTrait
{
    /**
     * Path to a file
     *
     * @var string|null
     */
    protected string|null $filePath = null;

    /**
     * Set file path
     *
     * @param string|null $path Path to a file
     *
     * @return self
     */
    public function setFilePath(string|null $path): static
    {
        $this->filePath = $path;

        return $this;
    }

    /**
     * Get file path
     *
     * If no file path value set, method
     * sets and returns a default file path.
     *
     * @see getDefaultFilePath()
     *
     * @return string|null file path or null if no file path has been set
     */
    public function getFilePath(): string|null
    {
        if (!$this->hasFilePath()) {
            $this->setFilePath($this->getDefaultFilePath());
        }
        return $this->filePath;
    }

    /**
     * Check if file path has been set
     *
     * @return bool True if file path has been set, false if not
     */
    public function hasFilePath(): bool
    {
        return isset($this->filePath);
    }

    /**
     * Get a default file path value, if any is available
     *
     * @return string|null Default file path value or null if no default value is available
     */
    public function getDefaultFilePath(): string|null
    {
        return null;
    }
}
