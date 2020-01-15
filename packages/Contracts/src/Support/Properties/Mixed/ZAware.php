<?php

namespace Aedart\Contracts\Support\Properties\Mixed;

/**
 * Z Aware
 *
 * Component is aware of mixed "z"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Mixed
 */
interface ZAware
{
    /**
     * Set z
     *
     * @param mixed|null $value Co-ordinate or value
     *
     * @return self
     */
    public function setZ($value);

    /**
     * Get z
     *
     * If no "z" value set, method
     * sets and returns a default "z".
     *
     * @see getDefaultZ()
     *
     * @return mixed|null z or null if no z has been set
     */
    public function getZ();

    /**
     * Check if "z" has been set
     *
     * @return bool True if "z" has been set, false if not
     */
    public function hasZ() : bool;

    /**
     * Get a default "z" value, if any is available
     *
     * @return mixed|null Default "z" value or null if no default value is available
     */
    public function getDefaultZ();
}
