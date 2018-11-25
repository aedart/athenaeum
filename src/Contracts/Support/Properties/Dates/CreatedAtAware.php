<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Created at Aware
 *
 * Component is aware of \DateTime "created at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface CreatedAtAware
{
    /**
     * Set created at
     *
     * @param \DateTime|null $date Date of when this component, entity or resource was created
     *
     * @return self
     */
    public function setCreatedAt(?\DateTime $date);

    /**
     * Get created at
     *
     * If no "created at" value set, method
     * sets and returns a default "created at".
     *
     * @see getDefaultCreatedAt()
     *
     * @return \DateTime|null created at or null if no created at has been set
     */
    public function getCreatedAt() : ?\DateTime;

    /**
     * Check if "created at" has been set
     *
     * @return bool True if "created at" has been set, false if not
     */
    public function hasCreatedAt() : bool;

    /**
     * Get a default "created at" value, if any is available
     *
     * @return \DateTime|null Default "created at" value or null if no default value is available
     */
    public function getDefaultCreatedAt() : ?\DateTime;
}
