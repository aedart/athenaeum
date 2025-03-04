<?php

namespace Aedart\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * X Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Mixes\XAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixes
 */
trait XTrait
{
    /**
     * Co-ordinate or value
     *
     * @var mixed
     */
    protected $x = null;

    /**
     * Set x
     *
     * @param mixed $value Co-ordinate or value
     *
     * @return self
     */
    public function setX(mixed $value): static
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
     * @return mixed x or null if no x has been set
     */
    public function getX(): mixed
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
     * @return mixed Default x value or null if no default value is available
     */
    public function getDefaultX(): mixed
    {
        return null;
    }
}
