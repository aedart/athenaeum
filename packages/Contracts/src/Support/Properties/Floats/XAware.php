<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * X Aware
 *
 * Component is aware of float "x"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface XAware
{
    /**
     * Set x
     *
     * @param float|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setX(?float $value);

    /**
     * Get x
     *
     * If no "x" value set, method
     * sets and returns a default "x".
     *
     * @see getDefaultX()
     *
     * @return float|null x or null if no x has been set
     */
    public function getX() : ?float;

    /**
     * Check if "x" has been set
     *
     * @return bool True if "x" has been set, false if not
     */
    public function hasX() : bool;

    /**
     * Get a default "x" value, if any is available
     *
     * @return float|null Default "x" value or null if no default value is available
     */
    public function getDefaultX() : ?float;
}
