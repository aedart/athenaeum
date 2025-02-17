<?php

namespace Aedart\Contracts\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Html Aware
 *
 * Component is aware of mixed "html"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Mixes
 */
interface HtmlAware
{
    /**
     * Set html
     *
     * @param mixed $html HyperText Markup Language (HTML)
     *
     * @return self
     */
    public function setHtml(mixed $html): static;

    /**
     * Get html
     *
     * If no html value set, method
     * sets and returns a default html.
     *
     * @see getDefaultHtml()
     *
     * @return mixed html or null if no html has been set
     */
    public function getHtml(): mixed;

    /**
     * Check if html has been set
     *
     * @return bool True if html has been set, false if not
     */
    public function hasHtml(): bool;

    /**
     * Get a default html value, if any is available
     *
     * @return mixed Default html value or null if no default value is available
     */
    public function getDefaultHtml(): mixed;
}
