<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Z Aware
 *
 * Component is aware of int "z"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface ZAware
{
    /**
     * Set z
     *
     * @param int|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setZ(int|null $value): static;

    /**
     * Get z
     *
     * If no z value set, method
     * sets and returns a default z.
     *
     * @see getDefaultZ()
     *
     * @return int|null z or null if no z has been set
     */
    public function getZ(): int|null;

    /**
     * Check if z has been set
     *
     * @return bool True if z has been set, false if not
     */
    public function hasZ(): bool;

    /**
     * Get a default z value, if any is available
     *
     * @return int|null Default z value or null if no default value is available
     */
    public function getDefaultZ(): int|null;
}
