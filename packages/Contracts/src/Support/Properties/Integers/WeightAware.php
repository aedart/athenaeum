<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Weight Aware
 *
 * Component is aware of int "weight"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface WeightAware
{
    /**
     * Set weight
     *
     * @param int|null $amount Weight of something
     *
     * @return self
     */
    public function setWeight(int|null $amount): static;

    /**
     * Get weight
     *
     * If no weight value set, method
     * sets and returns a default weight.
     *
     * @see getDefaultWeight()
     *
     * @return int|null weight or null if no weight has been set
     */
    public function getWeight(): int|null;

    /**
     * Check if weight has been set
     *
     * @return bool True if weight has been set, false if not
     */
    public function hasWeight(): bool;

    /**
     * Get a default weight value, if any is available
     *
     * @return int|null Default weight value or null if no default value is available
     */
    public function getDefaultWeight(): int|null;
}
