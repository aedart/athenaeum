<?php

namespace Aedart\Contracts\Circuits\States;

/**
 * State Factory Aware
 *
 * @see \Aedart\Contracts\Circuits\States\Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\States
 */
interface StateFactoryAware
{
    /**
     * Set state factory
     *
     * @param Factory|null $factory State Factory instance
     *
     * @return self
     */
    public function setStateFactory(Factory|null $factory): static;

    /**
     * Get state factory
     *
     * If no state factory has been set, this method will
     * set and return a default state factory, if any such
     * value is available
     *
     * @return Factory|null state factory or null if none state factory has been set
     */
    public function getStateFactory(): Factory|null;

    /**
     * Check if state factory has been set
     *
     * @return bool True if state factory has been set, false if not
     */
    public function hasStateFactory(): bool;

    /**
     * Get a default state factory value, if any is available
     *
     * @return Factory|null A default state factory value or Null if no default value is available
     */
    public function getDefaultStateFactory(): Factory|null;
}
