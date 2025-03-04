<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * State Aware
 *
 * Component is aware of int "state"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface StateAware
{
    /**
     * Set state
     *
     * @param int|null $state State of this component or what it represents
     *
     * @return self
     */
    public function setState(int|null $state): static;

    /**
     * Get state
     *
     * If no state value set, method
     * sets and returns a default state.
     *
     * @see getDefaultState()
     *
     * @return int|null state or null if no state has been set
     */
    public function getState(): int|null;

    /**
     * Check if state has been set
     *
     * @return bool True if state has been set, false if not
     */
    public function hasState(): bool;

    /**
     * Get a default state value, if any is available
     *
     * @return int|null Default state value or null if no default value is available
     */
    public function getDefaultState(): int|null;
}
