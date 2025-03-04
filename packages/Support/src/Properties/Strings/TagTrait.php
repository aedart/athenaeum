<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Tag Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\TagAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait TagTrait
{
    /**
     * Name of tag
     *
     * @var string|null
     */
    protected string|null $tag = null;

    /**
     * Set tag
     *
     * @param string|null $name Name of tag
     *
     * @return self
     */
    public function setTag(string|null $name): static
    {
        $this->tag = $name;

        return $this;
    }

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
    public function getTag(): string|null
    {
        if (!$this->hasTag()) {
            $this->setTag($this->getDefaultTag());
        }
        return $this->tag;
    }

    /**
     * Check if tag has been set
     *
     * @return bool True if tag has been set, false if not
     */
    public function hasTag(): bool
    {
        return isset($this->tag);
    }

    /**
     * Get a default tag value, if any is available
     *
     * @return string|null Default tag value or null if no default value is available
     */
    public function getDefaultTag(): string|null
    {
        return null;
    }
}
