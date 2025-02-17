<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Percent Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\PercentAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait PercentTrait
{
    /**
     * A part or other object per hundred
     *
     * @var float|null
     */
    protected float|null $percent = null;

    /**
     * Set percent
     *
     * @param float|null $percent A part or other object per hundred
     *
     * @return self
     */
    public function setPercent(float|null $percent): static
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * If no percent value set, method
     * sets and returns a default percent.
     *
     * @see getDefaultPercent()
     *
     * @return float|null percent or null if no percent has been set
     */
    public function getPercent(): float|null
    {
        if (!$this->hasPercent()) {
            $this->setPercent($this->getDefaultPercent());
        }
        return $this->percent;
    }

    /**
     * Check if percent has been set
     *
     * @return bool True if percent has been set, false if not
     */
    public function hasPercent(): bool
    {
        return isset($this->percent);
    }

    /**
     * Get a default percent value, if any is available
     *
     * @return float|null Default percent value or null if no default value is available
     */
    public function getDefaultPercent(): float|null
    {
        return null;
    }
}
