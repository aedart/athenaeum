<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Deleted at Aware
 *
 * Component is aware of \DateTime "deleted at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface DeletedAtAware
{
    /**
     * Set deleted at
     *
     * @param \DateTime|null $date Date of when this component, entity or resource was deleted
     *
     * @return self
     */
    public function setDeletedAt(?\DateTime $date);

    /**
     * Get deleted at
     *
     * If no "deleted at" value set, method
     * sets and returns a default "deleted at".
     *
     * @see getDefaultDeletedAt()
     *
     * @return \DateTime|null deleted at or null if no deleted at has been set
     */
    public function getDeletedAt(): ?\DateTime;

    /**
     * Check if "deleted at" has been set
     *
     * @return bool True if "deleted at" has been set, false if not
     */
    public function hasDeletedAt(): bool;

    /**
     * Get a default "deleted at" value, if any is available
     *
     * @return \DateTime|null Default "deleted at" value or null if no default value is available
     */
    public function getDefaultDeletedAt(): ?\DateTime;
}
