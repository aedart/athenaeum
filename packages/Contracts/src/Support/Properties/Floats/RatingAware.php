<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * Rating Aware
 *
 * Component is aware of float "rating"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface RatingAware
{
    /**
     * Set rating
     *
     * @param float|null $score The rating of something
     *
     * @return self
     */
    public function setRating(?float $score);

    /**
     * Get rating
     *
     * If no "rating" value set, method
     * sets and returns a default "rating".
     *
     * @see getDefaultRating()
     *
     * @return float|null rating or null if no rating has been set
     */
    public function getRating(): ?float;

    /**
     * Check if "rating" has been set
     *
     * @return bool True if "rating" has been set, false if not
     */
    public function hasRating(): bool;

    /**
     * Get a default "rating" value, if any is available
     *
     * @return float|null Default "rating" value or null if no default value is available
     */
    public function getDefaultRating(): ?float;
}
