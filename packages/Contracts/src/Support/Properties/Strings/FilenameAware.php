<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Filename Aware
 *
 * Component is aware of string "filename"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface FilenameAware
{
    /**
     * Set filename
     *
     * @param string|null $name Name of given file, with or without path, e.g. myText.txt, /usr/docs/README.md
     *
     * @return self
     */
    public function setFilename(string|null $name): static;

    /**
     * Get filename
     *
     * If no filename value set, method
     * sets and returns a default filename.
     *
     * @see getDefaultFilename()
     *
     * @return string|null filename or null if no filename has been set
     */
    public function getFilename(): string|null;

    /**
     * Check if filename has been set
     *
     * @return bool True if filename has been set, false if not
     */
    public function hasFilename(): bool;

    /**
     * Get a default filename value, if any is available
     *
     * @return string|null Default filename value or null if no default value is available
     */
    public function getDefaultFilename(): string|null;
}
