<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Prefix Aware
 *
 * Component is aware of string "prefix"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface PrefixAware
{
    /**
     * Set prefix
     *
     * @param string|null $prefix Prefix
     *
     * @return self
     */
    public function setPrefix(string|null $prefix): static;

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
    public function getPrefix(): string|null;

    /**
     * Check if prefix has been set
     *
     * @return bool True if prefix has been set, false if not
     */
    public function hasPrefix(): bool;

    /**
     * Get a default prefix value, if any is available
     *
     * @return string|null Default prefix value or null if no default value is available
     */
    public function getDefaultPrefix(): string|null;
}
