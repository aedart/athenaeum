<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Produced at Aware
 *
 * Component is aware of int "produced at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface ProducedAtAware
{
    /**
     * Set produced at
     *
     * @param int|null $date Date of when this component, entity or something was produced
     *
     * @return self
     */
    public function setProducedAt(int|null $date): static;

    /**
     * Get produced at
     *
     * If no produced at value set, method
     * sets and returns a default produced at.
     *
     * @see getDefaultProducedAt()
     *
     * @return int|null produced at or null if no produced at has been set
     */
    public function getProducedAt(): int|null;

    /**
     * Check if produced at has been set
     *
     * @return bool True if produced at has been set, false if not
     */
    public function hasProducedAt(): bool;

    /**
     * Get a default produced at value, if any is available
     *
     * @return int|null Default produced at value or null if no default value is available
     */
    public function getDefaultProducedAt(): int|null;
}
