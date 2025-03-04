<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * File extension Aware
 *
 * Component is aware of string "file extension"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface FileExtensionAware
{
    /**
     * Set file extension
     *
     * @param string|null $extension File extension, e.g. php, avi, json, txt...etc
     *
     * @return self
     */
    public function setFileExtension(string|null $extension): static;

    /**
     * Get file extension
     *
     * If no file extension value set, method
     * sets and returns a default file extension.
     *
     * @see getDefaultFileExtension()
     *
     * @return string|null file extension or null if no file extension has been set
     */
    public function getFileExtension(): string|null;

    /**
     * Check if file extension has been set
     *
     * @return bool True if file extension has been set, false if not
     */
    public function hasFileExtension(): bool;

    /**
     * Get a default file extension value, if any is available
     *
     * @return string|null Default file extension value or null if no default value is available
     */
    public function getDefaultFileExtension(): string|null;
}
