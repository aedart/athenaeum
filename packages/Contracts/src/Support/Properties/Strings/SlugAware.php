<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Slug Aware
 *
 * Component is aware of string "slug"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface SlugAware
{
    /**
     * Set slug
     *
     * @param string|null $slug Human readable keyword(s) that can be part or a Url
     *
     * @return self
     */
    public function setSlug(string|null $slug): static;

    /**
     * Get slug
     *
     * If no slug value set, method
     * sets and returns a default slug.
     *
     * @see getDefaultSlug()
     *
     * @return string|null slug or null if no slug has been set
     */
    public function getSlug(): string|null;

    /**
     * Check if slug has been set
     *
     * @return bool True if slug has been set, false if not
     */
    public function hasSlug(): bool;

    /**
     * Get a default slug value, if any is available
     *
     * @return string|null Default slug value or null if no default value is available
     */
    public function getDefaultSlug(): string|null;
}
