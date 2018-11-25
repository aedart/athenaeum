<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Text Aware
 *
 * Component is aware of string "text"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface TextAware
{
    /**
     * Set text
     *
     * @param string|null $text The full text content for something, e.g. an article&#039;s body text
     *
     * @return self
     */
    public function setText(?string $text);

    /**
     * Get text
     *
     * If no "text" value set, method
     * sets and returns a default "text".
     *
     * @see getDefaultText()
     *
     * @return string|null text or null if no text has been set
     */
    public function getText() : ?string;

    /**
     * Check if "text" has been set
     *
     * @return bool True if "text" has been set, false if not
     */
    public function hasText() : bool;

    /**
     * Get a default "text" value, if any is available
     *
     * @return string|null Default "text" value or null if no default value is available
     */
    public function getDefaultText() : ?string;
}
