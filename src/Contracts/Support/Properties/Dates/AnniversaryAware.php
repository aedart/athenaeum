<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Anniversary Aware
 *
 * Component is aware of \DateTime "anniversary"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface AnniversaryAware
{
    /**
     * Set anniversary
     *
     * @param \DateTime|null $anniversary Date of anniversary
     *
     * @return self
     */
    public function setAnniversary(?\DateTime $anniversary);

    /**
     * Get anniversary
     *
     * If no "anniversary" value set, method
     * sets and returns a default "anniversary".
     *
     * @see getDefaultAnniversary()
     *
     * @return \DateTime|null anniversary or null if no anniversary has been set
     */
    public function getAnniversary() : ?\DateTime;

    /**
     * Check if "anniversary" has been set
     *
     * @return bool True if "anniversary" has been set, false if not
     */
    public function hasAnniversary() : bool;

    /**
     * Get a default "anniversary" value, if any is available
     *
     * @return \DateTime|null Default "anniversary" value or null if no default value is available
     */
    public function getDefaultAnniversary() : ?\DateTime;
}
