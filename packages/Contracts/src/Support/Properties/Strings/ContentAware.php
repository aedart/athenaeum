<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Content Aware
 *
 * Component is aware of string "content"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ContentAware
{
    /**
     * Set content
     *
     * @param string|null $content Content
     *
     * @return self
     */
    public function setContent(string|null $content): static;

    /**
     * Get content
     *
     * If no content value set, method
     * sets and returns a default content.
     *
     * @see getDefaultContent()
     *
     * @return string|null content or null if no content has been set
     */
    public function getContent(): string|null;

    /**
     * Check if content has been set
     *
     * @return bool True if content has been set, false if not
     */
    public function hasContent(): bool;

    /**
     * Get a default content value, if any is available
     *
     * @return string|null Default content value or null if no default value is available
     */
    public function getDefaultContent(): string|null;
}
