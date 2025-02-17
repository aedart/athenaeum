<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Prefix Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\PrefixAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait PrefixTrait
{
    /**
     * Prefix
     *
     * @var string|null
     */
    protected string|null $prefix = null;

    /**
     * Set prefix
     *
     * @param string|null $prefix Prefix
     *
     * @return self
     */
    public function setPrefix(string|null $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * If no prefix value set, method
     * sets and returns a default prefix.
     *
     * @see getDefaultPrefix()
     *
     * @return string|null prefix or null if no prefix has been set
     */
    public function getPrefix(): string|null
    {
        if (!$this->hasPrefix()) {
            $this->setPrefix($this->getDefaultPrefix());
        }
        return $this->prefix;
    }

    /**
     * Check if prefix has been set
     *
     * @return bool True if prefix has been set, false if not
     */
    public function hasPrefix(): bool
    {
        return isset($this->prefix);
    }

    /**
     * Get a default prefix value, if any is available
     *
     * @return string|null Default prefix value or null if no default value is available
     */
    public function getDefaultPrefix(): string|null
    {
        return null;
    }
}
