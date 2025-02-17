<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Wildcard Aware
 *
 * Component is aware of string "wildcard"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface WildcardAware
{
    /**
     * Set wildcard
     *
     * @param string|null $identifier Wildcard identifier
     *
     * @return self
     */
    public function setWildcard(string|null $identifier): static;

    /**
     * Get wildcard
     *
     * If no wildcard value set, method
     * sets and returns a default wildcard.
     *
     * @see getDefaultWildcard()
     *
     * @return string|null wildcard or null if no wildcard has been set
     */
    public function getWildcard(): string|null;

    /**
     * Check if wildcard has been set
     *
     * @return bool True if wildcard has been set, false if not
     */
    public function hasWildcard(): bool;

    /**
     * Get a default wildcard value, if any is available
     *
     * @return string|null Default wildcard value or null if no default value is available
     */
    public function getDefaultWildcard(): string|null;
}
