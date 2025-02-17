<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Created at Aware
 *
 * Component is aware of \DateTimeInterface "created at"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface CreatedAtAware
{
    /**
     * Set created at
     *
     * @param \DateTimeInterface|null $date Date of when this component, entity or resource was created
     *
     * @return self
     */
    public function setCreatedAt(\DateTimeInterface|null $date): static;

    /**
     * Get created at
     *
     * If no created at value set, method
     * sets and returns a default created at.
     *
     * @see getDefaultCreatedAt()
     *
     * @return \DateTimeInterface|null created at or null if no created at has been set
     */
    public function getCreatedAt(): \DateTimeInterface|null;

    /**
     * Check if created at has been set
     *
     * @return bool True if created at has been set, false if not
     */
    public function hasCreatedAt(): bool;

    /**
     * Get a default created at value, if any is available
     *
     * @return \DateTimeInterface|null Default created at value or null if no default value is available
     */
    public function getDefaultCreatedAt(): \DateTimeInterface|null;
}
