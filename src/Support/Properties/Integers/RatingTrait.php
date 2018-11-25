<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Rating Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\RatingAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait RatingTrait
{
    /**
     * The rating of something
     *
     * @var int|null
     */
    protected $rating = null;

    /**
     * Set rating
     *
     * @param int|null $score The rating of something
     *
     * @return self
     */
    public function setRating(?int $score)
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
     * @return int|null rating or null if no rating has been set
     */
    public function getRating() : ?int
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
     * @return int|null Default "rating" value or null if no default value is available
     */
    public function getDefaultRating() : ?int
    {
        return null;
    }
}
