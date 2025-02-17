<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Rating Aware
 *
 * Component is aware of string "rating"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface RatingAware
{
    /**
     * Set rating
     *
     * @param string|null $score The rating of something
     *
     * @return self
     */
    public function setRating(string|null $score): static;

    /**
     * Get rating
     *
     * If no rating value set, method
     * sets and returns a default rating.
     *
     * @see getDefaultRating()
     *
     * @return string|null rating or null if no rating has been set
     */
    public function getRating(): string|null;

    /**
     * Check if rating has been set
     *
     * @return bool True if rating has been set, false if not
     */
    public function hasRating(): bool;

    /**
     * Get a default rating value, if any is available
     *
     * @return string|null Default rating value or null if no default value is available
     */
    public function getDefaultRating(): string|null;
}
