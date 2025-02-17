<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Percentage Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\PercentageAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait PercentageTrait
{
    /**
     * A proportion (especially per hundred)
     *
     * @var string|null
     */
    protected string|null $percentage = null;

    /**
     * Set percentage
     *
     * @param string|null $percentage A proportion (especially per hundred)
     *
     * @return self
     */
    public function setPercentage(string|null $percentage): static
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * If no percentage value set, method
     * sets and returns a default percentage.
     *
     * @see getDefaultPercentage()
     *
     * @return string|null percentage or null if no percentage has been set
     */
    public function getPercentage(): string|null
    {
        if (!$this->hasPercentage()) {
            $this->setPercentage($this->getDefaultPercentage());
        }
        return $this->percentage;
    }

    /**
     * Check if percentage has been set
     *
     * @return bool True if percentage has been set, false if not
     */
    public function hasPercentage(): bool
    {
        return isset($this->percentage);
    }

    /**
     * Get a default percentage value, if any is available
     *
     * @return string|null Default percentage value or null if no default value is available
     */
    public function getDefaultPercentage(): string|null
    {
        return null;
    }
}
