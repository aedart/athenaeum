<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * X Aware
 *
 * Component is aware of int "x"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface XAware
{
    /**
     * Set x
     *
     * @param int|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setX(?int $value);

    /**
     * Get x
     *
     * If no "x" value set, method
     * sets and returns a default "x".
     *
     * @see getDefaultX()
     *
     * @return int|null x or null if no x has been set
     */
    public function getX() : ?int;

    /**
     * Check if "x" has been set
     *
     * @return bool True if "x" has been set, false if not
     */
    public function hasX() : bool;

    /**
     * Get a default "x" value, if any is available
     *
     * @return int|null Default "x" value or null if no default value is available
     */
    public function getDefaultX() : ?int;
}
