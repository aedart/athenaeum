<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Release date Aware
 *
 * Component is aware of int "release date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface ReleaseDateAware
{
    /**
     * Set release date
     *
     * @param int|null $date Date of planned release
     *
     * @return self
     */
    public function setReleaseDate(int|null $date): static;

    /**
     * Get release date
     *
     * If no release date value set, method
     * sets and returns a default release date.
     *
     * @see getDefaultReleaseDate()
     *
     * @return int|null release date or null if no release date has been set
     */
    public function getReleaseDate(): int|null;

    /**
     * Check if release date has been set
     *
     * @return bool True if release date has been set, false if not
     */
    public function hasReleaseDate(): bool;

    /**
     * Get a default release date value, if any is available
     *
     * @return int|null Default release date value or null if no default value is available
     */
    public function getDefaultReleaseDate(): int|null;
}
