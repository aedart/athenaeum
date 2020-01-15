<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * Width Aware
 *
 * Component is aware of int "width"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface WidthAware
{
    /**
     * Set width
     *
     * @param int|null $amount Width of something
     *
     * @return self
     */
    public function setWidth(?int $amount);

    /**
     * Get width
     *
     * If no "width" value set, method
     * sets and returns a default "width".
     *
     * @see getDefaultWidth()
     *
     * @return int|null width or null if no width has been set
     */
    public function getWidth() : ?int;

    /**
     * Check if "width" has been set
     *
     * @return bool True if "width" has been set, false if not
     */
    public function hasWidth() : bool;

    /**
     * Get a default "width" value, if any is available
     *
     * @return int|null Default "width" value or null if no default value is available
     */
    public function getDefaultWidth() : ?int;
}
