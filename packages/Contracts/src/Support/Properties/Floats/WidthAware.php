<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Width Aware
 *
 * Component is aware of float "width"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface WidthAware
{
    /**
     * Set width
     *
     * @param float|null $amount Width of something
     *
     * @return self
     */
    public function setWidth(float|null $amount): static;

    /**
     * Get width
     *
     * If no width value set, method
     * sets and returns a default width.
     *
     * @see getDefaultWidth()
     *
     * @return float|null width or null if no width has been set
     */
    public function getWidth(): float|null;

    /**
     * Check if width has been set
     *
     * @return bool True if width has been set, false if not
     */
    public function hasWidth(): bool;

    /**
     * Get a default width value, if any is available
     *
     * @return float|null Default width value or null if no default value is available
     */
    public function getDefaultWidth(): float|null;
}
