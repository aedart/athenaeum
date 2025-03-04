<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Timestamp Aware
 *
 * Component is aware of int "timestamp"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface TimestampAware
{
    /**
     * Set timestamp
     *
     * @param int|null $timestamp Unix timestamp
     *
     * @return self
     */
    public function setTimestamp(int|null $timestamp): static;

    /**
     * Get timestamp
     *
     * If no timestamp value set, method
     * sets and returns a default timestamp.
     *
     * @see getDefaultTimestamp()
     *
     * @return int|null timestamp or null if no timestamp has been set
     */
    public function getTimestamp(): int|null;

    /**
     * Check if timestamp has been set
     *
     * @return bool True if timestamp has been set, false if not
     */
    public function hasTimestamp(): bool;

    /**
     * Get a default timestamp value, if any is available
     *
     * @return int|null Default timestamp value or null if no default value is available
     */
    public function getDefaultTimestamp(): int|null;
}
