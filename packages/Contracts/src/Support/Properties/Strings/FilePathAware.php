<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * File path Aware
 *
 * Component is aware of string "file path"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface FilePathAware
{
    /**
     * Set file path
     *
     * @param string|null $path Path to a file
     *
     * @return self
     */
    public function setFilePath(string|null $path): static;

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
    public function getFilePath(): string|null;

    /**
     * Check if file path has been set
     *
     * @return bool True if file path has been set, false if not
     */
    public function hasFilePath(): bool;

    /**
     * Get a default file path value, if any is available
     *
     * @return string|null Default file path value or null if no default value is available
     */
    public function getDefaultFilePath(): string|null;
}
