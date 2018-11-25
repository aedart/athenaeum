<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Suffix Aware
 *
 * Component is aware of string "suffix"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface SuffixAware
{
    /**
     * Set suffix
     *
     * @param string|null $suffix Suffix
     *
     * @return self
     */
    public function setSuffix(?string $suffix);

    /**
     * Get suffix
     *
     * If no "suffix" value set, method
     * sets and returns a default "suffix".
     *
     * @see getDefaultSuffix()
     *
     * @return string|null suffix or null if no suffix has been set
     */
    public function getSuffix() : ?string;

    /**
     * Check if "suffix" has been set
     *
     * @return bool True if "suffix" has been set, false if not
     */
    public function hasSuffix() : bool;

    /**
     * Get a default "suffix" value, if any is available
     *
     * @return string|null Default "suffix" value or null if no default value is available
     */
    public function getDefaultSuffix() : ?string;
}
