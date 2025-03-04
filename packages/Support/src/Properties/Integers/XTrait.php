<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * X Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\XAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait XTrait
{
    /**
     * Co-ordinate or value
     *
     * @var int|null
     */
    protected int|null $x = null;

    /**
     * Set x
     *
     * @param int|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setX(int|null $value): static
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
     * @return int|null x or null if no x has been set
     */
    public function getX(): int|null
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
     * @return int|null Default x value or null if no default value is available
     */
    public function getDefaultX(): int|null
    {
        return null;
    }
}
