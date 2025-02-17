<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * State Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\StateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait StateTrait
{
    /**
     * State of this component or what it represents. Alternative, state address
     *
     * @var string|null
     */
    protected string|null $state = null;

    /**
     * Set state
     *
     * @param string|null $state State of this component or what it represents. Alternative, state address
     *
     * @return self
     */
    public function setState(string|null $state): static
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * If no state value set, method
     * sets and returns a default state.
     *
     * @see getDefaultState()
     *
     * @return string|null state or null if no state has been set
     */
    public function getState(): string|null
    {
        if (!$this->hasState()) {
            $this->setState($this->getDefaultState());
        }
        return $this->state;
    }

    /**
     * Check if state has been set
     *
     * @return bool True if state has been set, false if not
     */
    public function hasState(): bool
    {
        return isset($this->state);
    }

    /**
     * Get a default state value, if any is available
     *
     * @return string|null Default state value or null if no default value is available
     */
    public function getDefaultState(): string|null
    {
        return null;
    }
}
