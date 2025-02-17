<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Weight Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\WeightAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait WeightTrait
{
    /**
     * Weight of something
     *
     * @var float|null
     */
    protected float|null $weight = null;

    /**
     * Set weight
     *
     * @param float|null $amount Weight of something
     *
     * @return self
     */
    public function setWeight(float|null $amount): static
    {
        $this->weight = $amount;

        return $this;
    }

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
    public function getWeight(): float|null
    {
        if (!$this->hasWeight()) {
            $this->setWeight($this->getDefaultWeight());
        }
        return $this->weight;
    }

    /**
     * Check if weight has been set
     *
     * @return bool True if weight has been set, false if not
     */
    public function hasWeight(): bool
    {
        return isset($this->weight);
    }

    /**
     * Get a default weight value, if any is available
     *
     * @return float|null Default weight value or null if no default value is available
     */
    public function getDefaultWeight(): float|null
    {
        return null;
    }
}
