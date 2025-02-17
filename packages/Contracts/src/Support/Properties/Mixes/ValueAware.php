<?php

namespace Aedart\Contracts\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Value Aware
 *
 * Component is aware of mixed "value"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Mixes
 */
interface ValueAware
{
    /**
     * Set value
     *
     * @param mixed $value Value
     *
     * @return self
     */
    public function setValue(mixed $value): static;

    /**
     * Get value
     *
     * If no value value set, method
     * sets and returns a default value.
     *
     * @see getDefaultValue()
     *
     * @return mixed value or null if no value has been set
     */
    public function getValue(): mixed;

    /**
     * Check if value has been set
     *
     * @return bool True if value has been set, false if not
     */
    public function hasValue(): bool;

    /**
     * Get a default value value, if any is available
     *
     * @return mixed Default value value or null if no default value is available
     */
    public function getDefaultValue(): mixed;
}
