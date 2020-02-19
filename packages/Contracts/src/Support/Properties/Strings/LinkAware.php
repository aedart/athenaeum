<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Link Aware
 *
 * Component is aware of string "link"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface LinkAware
{
    /**
     * Set link
     *
     * @param string|null $link Hyperlink to related resource or action
     *
     * @return self
     */
    public function setLink(?string $link);

    /**
     * Get link
     *
     * If no "link" value set, method
     * sets and returns a default "link".
     *
     * @see getDefaultLink()
     *
     * @return string|null link or null if no link has been set
     */
    public function getLink(): ?string;

    /**
     * Check if "link" has been set
     *
     * @return bool True if "link" has been set, false if not
     */
    public function hasLink(): bool;

    /**
     * Get a default "link" value, if any is available
     *
     * @return string|null Default "link" value or null if no default value is available
     */
    public function getDefaultLink(): ?string;
}
