<?php

namespace Aedart\Tests\Helpers\Dummies\Contracts;

/**
 * Box Aware
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Contracts
 */
interface BoxAware
{
    /**
     * Set box
     *
     * @param Box|null $box Box instance
     *
     * @return self
     */
    public function setBox(?Box $box);

    /**
     * Get box
     *
     * If no box has been set, this method will
     * set and return a default box, if any such
     * value is available
     *
     * @see getDefaultBox()
     *
     * @return Box|null box or null if none box has been set
     */
    public function getBox(): ?Box;

    /**
     * Check if box has been set
     *
     * @return bool True if box has been set, false if not
     */
    public function hasBox(): bool;

    /**
     * Get a default box value, if any is available
     *
     * @return Box|null A default box value or Null if no default value is available
     */
    public function getDefaultBox(): ?Box;
}
