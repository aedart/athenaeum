<?php

namespace Aedart\Contracts\Support\Properties\Dates;

/**
 * Release date Aware
 *
 * Component is aware of \DateTime "release date"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Dates
 */
interface ReleaseDateAware
{
    /**
     * Set release date
     *
     * @param \DateTime|null $date Date of planned release
     *
     * @return self
     */
    public function setReleaseDate(?\DateTime $date);

    /**
     * Get release date
     *
     * If no "release date" value set, method
     * sets and returns a default "release date".
     *
     * @see getDefaultReleaseDate()
     *
     * @return \DateTime|null release date or null if no release date has been set
     */
    public function getReleaseDate(): ?\DateTime;

    /**
     * Check if "release date" has been set
     *
     * @return bool True if "release date" has been set, false if not
     */
    public function hasReleaseDate(): bool;

    /**
     * Get a default "release date" value, if any is available
     *
     * @return \DateTime|null Default "release date" value or null if no default value is available
     */
    public function getDefaultReleaseDate(): ?\DateTime;
}
