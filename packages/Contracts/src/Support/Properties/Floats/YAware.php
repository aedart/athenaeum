<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Y Aware
 *
 * Component is aware of float "y"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface YAware
{
    /**
     * Set y
     *
     * @param float|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setY(float|null $value): static;

    /**
     * Get y
     *
     * If no y value set, method
     * sets and returns a default y.
     *
     * @see getDefaultY()
     *
     * @return float|null y or null if no y has been set
     */
    public function getY(): float|null;

    /**
     * Check if y has been set
     *
     * @return bool True if y has been set, false if not
     */
    public function hasY(): bool;

    /**
     * Get a default y value, if any is available
     *
     * @return float|null Default y value or null if no default value is available
     */
    public function getDefaultY(): float|null;
}
