<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * X Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\XAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait XTrait
{
    /**
     * Co-ordinate or value
     *
     * @var float|null
     */
    protected float|null $x = null;

    /**
     * Set x
     *
     * @param float|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setX(float|null $value): static
    {
        $this->x = $value;

        return $this;
    }

    /**
     * Get x
     *
     * If no x value set, method
     * sets and returns a default x.
     *
     * @see getDefaultX()
     *
     * @return float|null x or null if no x has been set
     */
    public function getX(): float|null
    {
        if (!$this->hasX()) {
            $this->setX($this->getDefaultX());
        }
        return $this->x;
    }

    /**
     * Check if x has been set
     *
     * @return bool True if x has been set, false if not
     */
    public function hasX(): bool
    {
        return isset($this->x);
    }

    /**
     * Get a default x value, if any is available
     *
     * @return float|null Default x value or null if no default value is available
     */
    public function getDefaultX(): float|null
    {
        return null;
    }
}
