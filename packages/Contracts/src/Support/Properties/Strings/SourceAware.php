<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Source Aware
 *
 * Component is aware of string "source"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface SourceAware
{
    /**
     * Set source
     *
     * @param string|null $source The source of something. E.g. location, reference, index key, or other identifier that can be used to determine the source
     *
     * @return self
     */
    public function setSource(string|null $source): static;

    /**
     * Get source
     *
     * If no source value set, method
     * sets and returns a default source.
     *
     * @see getDefaultSource()
     *
     * @return string|null source or null if no source has been set
     */
    public function getSource(): string|null;

    /**
     * Check if source has been set
     *
     * @return bool True if source has been set, false if not
     */
    public function hasSource(): bool;

    /**
     * Get a default source value, if any is available
     *
     * @return string|null Default source value or null if no default value is available
     */
    public function getDefaultSource(): string|null;
}
