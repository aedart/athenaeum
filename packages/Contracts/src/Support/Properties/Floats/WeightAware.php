<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Weight Aware
 *
 * Component is aware of float "weight"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface WeightAware
{
    /**
     * Set weight
     *
     * @param float|null $amount Weight of something
     *
     * @return self
     */
    public function setWeight(float|null $amount): static;

    /**
     * Get weight
     *
     * If no weight value set, method
     * sets and returns a default weight.
     *
     * @see getDefaultWeight()
     *
     * @return float|null weight or null if no weight has been set
     */
    public function getWeight(): float|null;

    /**
     * Check if weight has been set
     *
     * @return bool True if weight has been set, false if not
     */
    public function hasWeight(): bool;

    /**
     * Get a default weight value, if any is available
     *
     * @return float|null Default weight value or null if no default value is available
     */
    public function getDefaultWeight(): float|null;
}
