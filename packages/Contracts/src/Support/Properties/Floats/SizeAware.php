<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Size Aware
 *
 * Component is aware of float "size"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface SizeAware
{
    /**
     * Set size
     *
     * @param float|null $size The size of something
     *
     * @return self
     */
    public function setSize(float|null $size): static;

    /**
     * Get size
     *
     * If no size value set, method
     * sets and returns a default size.
     *
     * @see getDefaultSize()
     *
     * @return float|null size or null if no size has been set
     */
    public function getSize(): float|null;

    /**
     * Check if size has been set
     *
     * @return bool True if size has been set, false if not
     */
    public function hasSize(): bool;

    /**
     * Get a default size value, if any is available
     *
     * @return float|null Default size value or null if no default value is available
     */
    public function getDefaultSize(): float|null;
}
