<?php

namespace Aedart\Support\Properties\Arrays;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Tags Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Arrays\TagsAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Arrays
 */
trait TagsTrait
{
    /**
     * List of tags
     *
     * @var array|null
     */
    protected array|null $tags = null;

    /**
     * Set tags
     *
     * @param array|null $tags List of tags
     *
     * @return self
     */
    public function setTags(array|null $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

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
    public function getTags(): array|null
    {
        if (!$this->hasTags()) {
            $this->setTags($this->getDefaultTags());
        }
        return $this->tags;
    }

    /**
     * Check if tags has been set
     *
     * @return bool True if tags has been set, false if not
     */
    public function hasTags(): bool
    {
        return isset($this->tags);
    }

    /**
     * Get a default tags value, if any is available
     *
     * @return array|null Default tags value or null if no default value is available
     */
    public function getDefaultTags(): array|null
    {
        return null;
    }
}
