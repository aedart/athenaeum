<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Url Aware
 *
 * Component is aware of string "url"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface UrlAware
{
    /**
     * Set url
     *
     * @param string|null $webAddress Uniform Resource Locator (Url), commonly known as a web address
     *
     * @return self
     */
    public function setUrl(string|null $webAddress): static;

    /**
     * Get url
     *
     * If no url value set, method
     * sets and returns a default url.
     *
     * @see getDefaultUrl()
     *
     * @return string|null url or null if no url has been set
     */
    public function getUrl(): string|null;

    /**
     * Check if url has been set
     *
     * @return bool True if url has been set, false if not
     */
    public function hasUrl(): bool;

    /**
     * Get a default url value, if any is available
     *
     * @return string|null Default url value or null if no default value is available
     */
    public function getDefaultUrl(): string|null;
}
