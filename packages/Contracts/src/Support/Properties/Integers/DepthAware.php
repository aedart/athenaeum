<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Depth Aware
 *
 * Component is aware of int "depth"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface DepthAware
{
    /**
     * Set depth
     *
     * @param int|null $amount Depth of something
     *
     * @return self
     */
    public function setDepth(int|null $amount): static;

    /**
     * Get depth
     *
     * If no depth value set, method
     * sets and returns a default depth.
     *
     * @see getDefaultDepth()
     *
     * @return int|null depth or null if no depth has been set
     */
    public function getDepth(): int|null;

    /**
     * Check if depth has been set
     *
     * @return bool True if depth has been set, false if not
     */
    public function hasDepth(): bool;

    /**
     * Get a default depth value, if any is available
     *
     * @return int|null Default depth value or null if no default value is available
     */
    public function getDefaultDepth(): int|null;
}
