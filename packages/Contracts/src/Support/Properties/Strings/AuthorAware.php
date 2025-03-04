<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Author Aware
 *
 * Component is aware of string "author"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface AuthorAware
{
    /**
     * Set author
     *
     * @param string|null $name Name of author
     *
     * @return self
     */
    public function setAuthor(string|null $name): static;

    /**
     * Get author
     *
     * If no author value set, method
     * sets and returns a default author.
     *
     * @see getDefaultAuthor()
     *
     * @return string|null author or null if no author has been set
     */
    public function getAuthor(): string|null;

    /**
     * Check if author has been set
     *
     * @return bool True if author has been set, false if not
     */
    public function hasAuthor(): bool;

    /**
     * Get a default author value, if any is available
     *
     * @return string|null Default author value or null if no default value is available
     */
    public function getDefaultAuthor(): string|null;
}
