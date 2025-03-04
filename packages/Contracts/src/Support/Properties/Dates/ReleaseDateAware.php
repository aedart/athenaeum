<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Release date Aware
 *
 * Component is aware of \DateTimeInterface "release date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface ReleaseDateAware
{
    /**
     * Set release date
     *
     * @param \DateTimeInterface|null $date Date of planned release
     *
     * @return self
     */
    public function setReleaseDate(\DateTimeInterface|null $date): static;

    /**
     * Get release date
     *
     * If no release date value set, method
     * sets and returns a default release date.
     *
     * @see getDefaultReleaseDate()
     *
     * @return \DateTimeInterface|null release date or null if no release date has been set
     */
    public function getReleaseDate(): \DateTimeInterface|null;

    /**
     * Check if release date has been set
     *
     * @return bool True if release date has been set, false if not
     */
    public function hasReleaseDate(): bool;

    /**
     * Get a default release date value, if any is available
     *
     * @return \DateTimeInterface|null Default release date value or null if no default value is available
     */
    public function getDefaultReleaseDate(): \DateTimeInterface|null;
}
