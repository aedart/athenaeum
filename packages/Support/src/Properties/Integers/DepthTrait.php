<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Depth Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\DepthAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait DepthTrait
{
    /**
     * Depth of something
     *
     * @var int|null
     */
    protected int|null $depth = null;

    /**
     * Set depth
     *
     * @param int|null $amount Depth of something
     *
     * @return self
     */
    public function setDepth(int|null $amount): static
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
     * @return int|null depth or null if no depth has been set
     */
    public function getDepth(): int|null
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
     * @return int|null Default depth value or null if no default value is available
     */
    public function getDefaultDepth(): int|null
    {
        return null;
    }
}
