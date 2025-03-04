<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Released at Aware
 *
 * Component is aware of int "released at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface ReleasedAtAware
{
    /**
     * Set released at
     *
     * @param int|null $date Date of when this component, entity or something was released
     *
     * @return self
     */
    public function setReleasedAt(int|null $date): static;

    /**
     * Get released at
     *
     * If no released at value set, method
     * sets and returns a default released at.
     *
     * @see getDefaultReleasedAt()
     *
     * @return int|null released at or null if no released at has been set
     */
    public function getReleasedAt(): int|null;

    /**
     * Check if released at has been set
     *
     * @return bool True if released at has been set, false if not
     */
    public function hasReleasedAt(): bool;

    /**
     * Get a default released at value, if any is available
     *
     * @return int|null Default released at value or null if no default value is available
     */
    public function getDefaultReleasedAt(): int|null;
}
