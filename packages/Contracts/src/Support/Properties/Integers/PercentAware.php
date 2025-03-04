<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Percent Aware
 *
 * Component is aware of int "percent"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface PercentAware
{
    /**
     * Set percent
     *
     * @param int|null $percent A part or other object per hundred
     *
     * @return self
     */
    public function setPercent(int|null $percent): static;

    /**
     * Get percent
     *
     * If no percent value set, method
     * sets and returns a default percent.
     *
     * @see getDefaultPercent()
     *
     * @return int|null percent or null if no percent has been set
     */
    public function getPercent(): int|null;

    /**
     * Check if percent has been set
     *
     * @return bool True if percent has been set, false if not
     */
    public function hasPercent(): bool;

    /**
     * Get a default percent value, if any is available
     *
     * @return int|null Default percent value or null if no default value is available
     */
    public function getDefaultPercent(): int|null;
}
