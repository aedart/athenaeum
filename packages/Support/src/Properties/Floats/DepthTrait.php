<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Depth Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\DepthAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait DepthTrait
{
    /**
     * Depth of something
     *
     * @var float|null
     */
    protected float|null $depth = null;

    /**
     * Set depth
     *
     * @param float|null $amount Depth of something
     *
     * @return self
     */
    public function setDepth(float|null $amount): static
    {
        $this->depth = $amount;

        return $this;
    }

    /**
     * Get depth
     *
     * If no depth value set, method
     * sets and returns a default depth.
     *
     * @see getDefaultDepth()
     *
     * @return float|null depth or null if no depth has been set
     */
    public function getDepth(): float|null
    {
        if (!$this->hasDepth()) {
            $this->setDepth($this->getDefaultDepth());
        }
        return $this->depth;
    }

    /**
     * Check if depth has been set
     *
     * @return bool True if depth has been set, false if not
     */
    public function hasDepth(): bool
    {
        return isset($this->depth);
    }

    /**
     * Get a default depth value, if any is available
     *
     * @return float|null Default depth value or null if no default value is available
     */
    public function getDefaultDepth(): float|null
    {
        return null;
    }
}
