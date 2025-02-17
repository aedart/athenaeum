<?php

namespace Aedart\Contracts\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * X Aware
 *
 * Component is aware of mixed "x"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Mixes
 */
interface XAware
{
    /**
     * Set x
     *
     * @param mixed $value Co-ordinate or value
     *
     * @return self
     */
    public function setX(mixed $value): static;

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
    public function getX(): mixed;

    /**
     * Check if x has been set
     *
     * @return bool True if x has been set, false if not
     */
    public function hasX(): bool;

    /**
     * Get a default x value, if any is available
     *
     * @return mixed Default x value or null if no default value is available
     */
    public function getDefaultX(): mixed;
}
