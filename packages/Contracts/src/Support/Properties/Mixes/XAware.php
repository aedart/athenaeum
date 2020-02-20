<?php

namespace Aedart\Contracts\Support\Properties\Mixes;

/**
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
     * @param mixed|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setX($value);

    /**
     * Get x
     *
     * If no "x" value set, method
     * sets and returns a default "x".
     *
     * @see getDefaultX()
     *
     * @return mixed|null x or null if no x has been set
     */
    public function getX();

    /**
     * Check if "x" has been set
     *
     * @return bool True if "x" has been set, false if not
     */
    public function hasX(): bool;

    /**
     * Get a default "x" value, if any is available
     *
     * @return mixed|null Default "x" value or null if no default value is available
     */
    public function getDefaultX();
}
