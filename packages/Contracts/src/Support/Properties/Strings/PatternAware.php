<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Pattern Aware
 *
 * Component is aware of string "pattern"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface PatternAware
{
    /**
     * Set pattern
     *
     * @param string|null $pattern Some kind of a pattern, e.g. search or regex
     *
     * @return self
     */
    public function setPattern(string|null $pattern): static;

    /**
     * Get pattern
     *
     * If no pattern value set, method
     * sets and returns a default pattern.
     *
     * @see getDefaultPattern()
     *
     * @return string|null pattern or null if no pattern has been set
     */
    public function getPattern(): string|null;

    /**
     * Check if pattern has been set
     *
     * @return bool True if pattern has been set, false if not
     */
    public function hasPattern(): bool;

    /**
     * Get a default pattern value, if any is available
     *
     * @return string|null Default pattern value or null if no default value is available
     */
    public function getDefaultPattern(): string|null;
}
