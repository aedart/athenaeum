<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Z Aware
 *
 * Component is aware of float "z"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface ZAware
{
    /**
     * Set z
     *
     * @param float|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setZ(float|null $value): static;

    /**
     * Get z
     *
     * If no z value set, method
     * sets and returns a default z.
     *
     * @see getDefaultZ()
     *
     * @return float|null z or null if no z has been set
     */
    public function getZ(): float|null;

    /**
     * Check if z has been set
     *
     * @return bool True if z has been set, false if not
     */
    public function hasZ(): bool;

    /**
     * Get a default z value, if any is available
     *
     * @return float|null Default z value or null if no default value is available
     */
    public function getDefaultZ(): float|null;
}
