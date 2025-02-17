<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Rating Aware
 *
 * Component is aware of int "rating"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface RatingAware
{
    /**
     * Set rating
     *
     * @param int|null $score The rating of something
     *
     * @return self
     */
    public function setRating(int|null $score): static;

    /**
     * Get rating
     *
     * If no rating value set, method
     * sets and returns a default rating.
     *
     * @see getDefaultRating()
     *
     * @return int|null rating or null if no rating has been set
     */
    public function getRating(): int|null;

    /**
     * Check if rating has been set
     *
     * @return bool True if rating has been set, false if not
     */
    public function hasRating(): bool;

    /**
     * Get a default rating value, if any is available
     *
     * @return int|null Default rating value or null if no default value is available
     */
    public function getDefaultRating(): int|null;
}
