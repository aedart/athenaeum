<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Version Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\VersionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait VersionTrait
{
    /**
     * Version
     *
     * @var string|null
     */
    protected string|null $version = null;

    /**
     * Set version
     *
     * @param string|null $version Version
     *
     * @return self
     */
    public function setVersion(string|null $version): static
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * If no version value set, method
     * sets and returns a default version.
     *
     * @see getDefaultVersion()
     *
     * @return string|null version or null if no version has been set
     */
    public function getVersion(): string|null
    {
        if (!$this->hasVersion()) {
            $this->setVersion($this->getDefaultVersion());
        }
        return $this->version;
    }

    /**
     * Check if version has been set
     *
     * @return bool True if version has been set, false if not
     */
    public function hasVersion(): bool
    {
        return isset($this->version);
    }

    /**
     * Get a default version value, if any is available
     *
     * @return string|null Default version value or null if no default value is available
     */
    public function getDefaultVersion(): string|null
    {
        return null;
    }
}
