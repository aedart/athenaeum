<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Percentage Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\PercentageAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait PercentageTrait
{
    /**
     * A part or other object per hundred
     *
     * @var int|null
     */
    protected ?int $percentage = null;

    /**
     * Set percentage
     *
     * @param int|null $percentage A part or other object per hundred
     *
     * @return self
     */
    public function setPercentage(?int $percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * If no "percentage" value set, method
     * sets and returns a default "percentage".
     *
     * @see getDefaultPercentage()
     *
     * @return int|null percentage or null if no percentage has been set
     */
    public function getPercentage(): ?int
    {
        if (!$this->hasPercentage()) {
            $this->setPercentage($this->getDefaultPercentage());
        }
        return $this->percentage;
    }

    /**
     * Check if "percentage" has been set
     *
     * @return bool True if "percentage" has been set, false if not
     */
    public function hasPercentage(): bool
    {
        return isset($this->percentage);
    }

    /**
     * Get a default "percentage" value, if any is available
     *
     * @return int|null Default "percentage" value or null if no default value is available
     */
    public function getDefaultPercentage(): ?int
    {
        return null;
    }
}
