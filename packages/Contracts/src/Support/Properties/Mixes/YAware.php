<?php

namespace Aedart\Contracts\Support\Properties\Mixes;

/**
 * Y Aware
 *
 * Component is aware of mixed "y"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Mixes
 */
interface YAware
{
    /**
     * Set y
     *
     * @param mixed|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setY($value);

    /**
     * Get y
     *
     * If no "y" value set, method
     * sets and returns a default "y".
     *
     * @see getDefaultY()
     *
     * @return mixed|null y or null if no y has been set
     */
    public function getY();

    /**
     * Check if "y" has been set
     *
     * @return bool True if "y" has been set, false if not
     */
    public function hasY(): bool;

    /**
     * Get a default "y" value, if any is available
     *
     * @return mixed|null Default "y" value or null if no default value is available
     */
    public function getDefaultY();
}
