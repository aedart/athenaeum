<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Release date Aware
 *
 * Component is aware of string "release date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ReleaseDateAware
{
    /**
     * Set release date
     *
     * @param string|null $date Date of planned release
     *
     * @return self
     */
    public function setReleaseDate(string|null $date): static;

    /**
     * Get release date
     *
     * If no release date value set, method
     * sets and returns a default release date.
     *
     * @see getDefaultReleaseDate()
     *
     * @return string|null release date or null if no release date has been set
     */
    public function getReleaseDate(): string|null;

    /**
     * Check if release date has been set
     *
     * @return bool True if release date has been set, false if not
     */
    public function hasReleaseDate(): bool;

    /**
     * Get a default release date value, if any is available
     *
     * @return string|null Default release date value or null if no default value is available
     */
    public function getDefaultReleaseDate(): string|null;
}
