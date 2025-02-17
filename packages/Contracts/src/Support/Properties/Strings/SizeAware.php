<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Size Aware
 *
 * Component is aware of string "size"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface SizeAware
{
    /**
     * Set size
     *
     * @param string|null $size The size of something
     *
     * @return self
     */
    public function setSize(string|null $size): static;

    /**
     * Get size
     *
     * If no size value set, method
     * sets and returns a default size.
     *
     * @see getDefaultSize()
     *
     * @return string|null size or null if no size has been set
     */
    public function getSize(): string|null;

    /**
     * Check if size has been set
     *
     * @return bool True if size has been set, false if not
     */
    public function hasSize(): bool;

    /**
     * Get a default size value, if any is available
     *
     * @return string|null Default size value or null if no default value is available
     */
    public function getDefaultSize(): string|null;
}
