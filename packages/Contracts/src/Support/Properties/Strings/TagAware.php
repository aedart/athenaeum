<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Tag Aware
 *
 * Component is aware of string "tag"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface TagAware
{
    /**
     * Set tag
     *
     * @param string|null $name Name of tag
     *
     * @return self
     */
    public function setTag(string|null $name): static;

    /**
     * Get tag
     *
     * If no tag value set, method
     * sets and returns a default tag.
     *
     * @see getDefaultTag()
     *
     * @return string|null tag or null if no tag has been set
     */
    public function getTag(): string|null;

    /**
     * Check if tag has been set
     *
     * @return bool True if tag has been set, false if not
     */
    public function hasTag(): bool;

    /**
     * Get a default tag value, if any is available
     *
     * @return string|null Default tag value or null if no default value is available
     */
    public function getDefaultTag(): string|null;
}
