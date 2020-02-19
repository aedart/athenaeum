<?php

namespace Aedart\Contracts\Support\Properties\Mixed;

/**
 * Html Aware
 *
 * Component is aware of mixed "html"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Mixed
 */
interface HtmlAware
{
    /**
     * Set html
     *
     * @param mixed|null $html HyperText Markup Language (HTML)
     *
     * @return self
     */
    public function setHtml($html);

    /**
     * Get html
     *
     * If no "html" value set, method
     * sets and returns a default "html".
     *
     * @see getDefaultHtml()
     *
     * @return mixed|null html or null if no html has been set
     */
    public function getHtml();

    /**
     * Check if "html" has been set
     *
     * @return bool True if "html" has been set, false if not
     */
    public function hasHtml(): bool;

    /**
     * Get a default "html" value, if any is available
     *
     * @return mixed|null Default "html" value or null if no default value is available
     */
    public function getDefaultHtml();
}
