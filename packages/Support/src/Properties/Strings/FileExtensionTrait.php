<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * File extension Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\FileExtensionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait FileExtensionTrait
{
    /**
     * File extension, e.g. php, avi, json, txt...etc
     *
     * @var string|null
     */
    protected string|null $fileExtension = null;

    /**
     * Set file extension
     *
     * @param string|null $extension File extension, e.g. php, avi, json, txt...etc
     *
     * @return self
     */
    public function setFileExtension(string|null $extension): static
    {
        $this->fileExtension = $extension;

        return $this;
    }

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
    public function getFileExtension(): string|null
    {
        if (!$this->hasFileExtension()) {
            $this->setFileExtension($this->getDefaultFileExtension());
        }
        return $this->fileExtension;
    }

    /**
     * Check if file extension has been set
     *
     * @return bool True if file extension has been set, false if not
     */
    public function hasFileExtension(): bool
    {
        return isset($this->fileExtension);
    }

    /**
     * Get a default file extension value, if any is available
     *
     * @return string|null Default file extension value or null if no default value is available
     */
    public function getDefaultFileExtension(): string|null
    {
        return null;
    }
}
