<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Html Aware
 *
 * Component is aware of string "html"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface HtmlAware
{
    /**
     * Set html
     *
     * @param string|null $html HyperText Markup Language (HTML)
     *
     * @return self
     */
    public function setHtml(string|null $html): static;

    /**
     * Get html
     *
     * If no html value set, method
     * sets and returns a default html.
     *
     * @see getDefaultHtml()
     *
     * @return string|null html or null if no html has been set
     */
    public function getHtml(): string|null;

    /**
     * Check if html has been set
     *
     * @return bool True if html has been set, false if not
     */
    public function hasHtml(): bool;

    /**
     * Get a default html value, if any is available
     *
     * @return string|null Default html value or null if no default value is available
     */
    public function getDefaultHtml(): string|null;
}
