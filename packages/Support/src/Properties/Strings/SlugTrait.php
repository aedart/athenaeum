<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Slug Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\SlugAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait SlugTrait
{
    /**
     * Human readable keyword(s) that can be part or a Url
     *
     * @var string|null
     */
    protected string|null $slug = null;

    /**
     * Set slug
     *
     * @param string|null $slug Human readable keyword(s) that can be part or a Url
     *
     * @return self
     */
    public function setSlug(string|null $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

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
    public function getSlug(): string|null
    {
        if (!$this->hasSlug()) {
            $this->setSlug($this->getDefaultSlug());
        }
        return $this->slug;
    }

    /**
     * Check if slug has been set
     *
     * @return bool True if slug has been set, false if not
     */
    public function hasSlug(): bool
    {
        return isset($this->slug);
    }

    /**
     * Get a default slug value, if any is available
     *
     * @return string|null Default slug value or null if no default value is available
     */
    public function getDefaultSlug(): string|null
    {
        return null;
    }
}
