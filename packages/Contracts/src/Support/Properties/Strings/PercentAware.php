<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Percent Aware
 *
 * Component is aware of string "percent"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface PercentAware
{
    /**
     * Set percent
     *
     * @param string|null $percent A part or other object per hundred
     *
     * @return self
     */
    public function setPercent(string|null $percent): static;

    /**
     * Get percent
     *
     * If no percent value set, method
     * sets and returns a default percent.
     *
     * @see getDefaultPercent()
     *
     * @return string|null percent or null if no percent has been set
     */
    public function getPercent(): string|null;

    /**
     * Check if percent has been set
     *
     * @return bool True if percent has been set, false if not
     */
    public function hasPercent(): bool;

    /**
     * Get a default percent value, if any is available
     *
     * @return string|null Default percent value or null if no default value is available
     */
    public function getDefaultPercent(): string|null;
}
