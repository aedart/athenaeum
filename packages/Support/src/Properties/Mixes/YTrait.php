<?php

namespace Aedart\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Y Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Mixes\YAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixes
 */
trait YTrait
{
    /**
     * Co-ordinate or value
     *
     * @var mixed
     */
    protected $y = null;

    /**
     * Set y
     *
     * @param mixed $value Co-ordinate or value
     *
     * @return self
     */
    public function setY(mixed $value): static
    {
        $this->y = $value;

        return $this;
    }

    /**
     * Get y
     *
     * If no y value set, method
     * sets and returns a default y.
     *
     * @see getDefaultY()
     *
     * @return mixed y or null if no y has been set
     */
    public function getY(): mixed
    {
        if (!$this->hasY()) {
            $this->setY($this->getDefaultY());
        }
        return $this->y;
    }

    /**
     * Check if y has been set
     *
     * @return bool True if y has been set, false if not
     */
    public function hasY(): bool
    {
        return isset($this->y);
    }

    /**
     * Get a default y value, if any is available
     *
     * @return mixed Default y value or null if no default value is available
     */
    public function getDefaultY(): mixed
    {
        return null;
    }
}
