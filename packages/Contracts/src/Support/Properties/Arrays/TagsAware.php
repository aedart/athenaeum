<?php

namespace Aedart\Contracts\Support\Properties\Arrays;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Tags Aware
 *
 * Component is aware of array "tags"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Arrays
 */
interface TagsAware
{
    /**
     * Set tags
     *
     * @param array|null $tags List of tags
     *
     * @return self
     */
    public function setTags(array|null $tags): static;

    /**
     * Get tags
     *
     * If no tags value set, method
     * sets and returns a default tags.
     *
     * @see getDefaultTags()
     *
     * @return array|null tags or null if no tags has been set
     */
    public function getTags(): array|null;

    /**
     * Check if tags has been set
     *
     * @return bool True if tags has been set, false if not
     */
    public function hasTags(): bool;

    /**
     * Get a default tags value, if any is available
     *
     * @return array|null Default tags value or null if no default value is available
     */
    public function getDefaultTags(): array|null;
}
