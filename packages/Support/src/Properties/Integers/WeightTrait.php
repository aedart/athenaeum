<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Weight Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\WeightAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait WeightTrait
{
    /**
     * Weight of something
     *
     * @var int|null
     */
    protected ?int $weight = null;

    /**
     * Set weight
     *
     * @param int|null $amount Weight of something
     *
     * @return self
     */
    public function setWeight(?int $amount)
    {
        $this->weight = $amount;

        return $this;
    }

    /**
     * Get weight
     *
     * If no "weight" value set, method
     * sets and returns a default "weight".
     *
     * @see getDefaultWeight()
     *
     * @return int|null weight or null if no weight has been set
     */
    public function getWeight(): ?int
    {
        if (!$this->hasWeight()) {
            $this->setWeight($this->getDefaultWeight());
        }
        return $this->weight;
    }

    /**
     * Check if "weight" has been set
     *
     * @return bool True if "weight" has been set, false if not
     */
    public function hasWeight(): bool
    {
        return isset($this->weight);
    }

    /**
     * Get a default "weight" value, if any is available
     *
     * @return int|null Default "weight" value or null if no default value is available
     */
    public function getDefaultWeight(): ?int
    {
        return null;
    }
}
