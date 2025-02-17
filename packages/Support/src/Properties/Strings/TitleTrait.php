<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Title Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\TitleAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait TitleTrait
{
    /**
     * Title
     *
     * @var string|null
     */
    protected string|null $title = null;

    /**
     * Set title
     *
     * @param string|null $title Title
     *
     * @return self
     */
    public function setTitle(string|null $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * If no title value set, method
     * sets and returns a default title.
     *
     * @see getDefaultTitle()
     *
     * @return string|null title or null if no title has been set
     */
    public function getTitle(): string|null
    {
        if (!$this->hasTitle()) {
            $this->setTitle($this->getDefaultTitle());
        }
        return $this->title;
    }

    /**
     * Check if title has been set
     *
     * @return bool True if title has been set, false if not
     */
    public function hasTitle(): bool
    {
        return isset($this->title);
    }

    /**
     * Get a default title value, if any is available
     *
     * @return string|null Default title value or null if no default value is available
     */
    public function getDefaultTitle(): string|null
    {
        return null;
    }
}
