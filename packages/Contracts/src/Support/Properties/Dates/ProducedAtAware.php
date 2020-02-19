<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Produced at Aware
 *
 * Component is aware of \DateTime "produced at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface ProducedAtAware
{
    /**
     * Set produced at
     *
     * @param \DateTime|null $date Date of when this component, entity or something was produced
     *
     * @return self
     */
    public function setProducedAt(?\DateTime $date);

    /**
     * Get produced at
     *
     * If no "produced at" value set, method
     * sets and returns a default "produced at".
     *
     * @see getDefaultProducedAt()
     *
     * @return \DateTime|null produced at or null if no produced at has been set
     */
    public function getProducedAt(): ?\DateTime;

    /**
     * Check if "produced at" has been set
     *
     * @return bool True if "produced at" has been set, false if not
     */
    public function hasProducedAt(): bool;

    /**
     * Get a default "produced at" value, if any is available
     *
     * @return \DateTime|null Default "produced at" value or null if no default value is available
     */
    public function getDefaultProducedAt(): ?\DateTime;
}
