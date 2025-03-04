<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Length Aware
 *
 * Component is aware of int "length"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface LengthAware
{
    /**
     * Set length
     *
     * @param int|null $amount Length of something
     *
     * @return self
     */
    public function setLength(int|null $amount): static;

    /**
     * Get length
     *
     * If no length value set, method
     * sets and returns a default length.
     *
     * @see getDefaultLength()
     *
     * @return int|null length or null if no length has been set
     */
    public function getLength(): int|null;

    /**
     * Check if length has been set
     *
     * @return bool True if length has been set, false if not
     */
    public function hasLength(): bool;

    /**
     * Get a default length value, if any is available
     *
     * @return int|null Default length value or null if no default value is available
     */
    public function getDefaultLength(): int|null;
}
