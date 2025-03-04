<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Depth Aware
 *
 * Component is aware of float "depth"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface DepthAware
{
    /**
     * Set depth
     *
     * @param float|null $amount Depth of something
     *
     * @return self
     */
    public function setDepth(float|null $amount): static;

    /**
     * Get depth
     *
     * If no depth value set, method
     * sets and returns a default depth.
     *
     * @see getDefaultDepth()
     *
     * @return float|null depth or null if no depth has been set
     */
    public function getDepth(): float|null;

    /**
     * Check if depth has been set
     *
     * @return bool True if depth has been set, false if not
     */
    public function hasDepth(): bool;

    /**
     * Get a default depth value, if any is available
     *
     * @return float|null Default depth value or null if no default value is available
     */
    public function getDefaultDepth(): float|null;
}
