<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Produced at Aware
 *
 * Component is aware of \DateTimeInterface "produced at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface ProducedAtAware
{
    /**
     * Set produced at
     *
     * @param \DateTimeInterface|null $date Date of when this component, entity or something was produced
     *
     * @return self
     */
    public function setProducedAt(\DateTimeInterface|null $date): static;

    /**
     * Get produced at
     *
     * If no produced at value set, method
     * sets and returns a default produced at.
     *
     * @see getDefaultProducedAt()
     *
     * @return \DateTimeInterface|null produced at or null if no produced at has been set
     */
    public function getProducedAt(): \DateTimeInterface|null;

    /**
     * Check if produced at has been set
     *
     * @return bool True if produced at has been set, false if not
     */
    public function hasProducedAt(): bool;

    /**
     * Get a default produced at value, if any is available
     *
     * @return \DateTimeInterface|null Default produced at value or null if no default value is available
     */
    public function getDefaultProducedAt(): \DateTimeInterface|null;
}
