<?php

namespace Aedart\Support\Properties\Floats;

/**
 * Rating Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\RatingAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait RatingTrait
{
    /**
     * The rating of something
     *
     * @var float|null
     */
    protected $rating = null;

    /**
     * Set rating
     *
     * @param float|null $score The rating of something
     *
     * @return self
     */
    public function setRating(?float $score)
    {
        $this->rating = $score;

        return $this;
    }

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
    public function getRating() : ?float
    {
        if ( ! $this->hasRating()) {
            $this->setRating($this->getDefaultRating());
        }
        return $this->rating;
    }

    /**
     * Check if "rating" has been set
     *
     * @return bool True if "rating" has been set, false if not
     */
    public function hasRating() : bool
    {
        return isset($this->rating);
    }

    /**
     * Get a default "rating" value, if any is available
     *
     * @return float|null Default "rating" value or null if no default value is available
     */
    public function getDefaultRating() : ?float
    {
        return null;
    }
}
