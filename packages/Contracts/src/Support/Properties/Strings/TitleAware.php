<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Title Aware
 *
 * Component is aware of string "title"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface TitleAware
{
    /**
     * Set title
     *
     * @param string|null $title Title
     *
     * @return self
     */
    public function setTitle(string|null $title): static;

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
    public function getTitle(): string|null;

    /**
     * Check if title has been set
     *
     * @return bool True if title has been set, false if not
     */
    public function hasTitle(): bool;

    /**
     * Get a default title value, if any is available
     *
     * @return string|null Default title value or null if no default value is available
     */
    public function getDefaultTitle(): string|null;
}
