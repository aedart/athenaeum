<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Rating Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\RatingAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait RatingTrait
{
    /**
     * The rating of something
     *
     * @var string|null
     */
    protected ?string $rating = null;

    /**
     * Set rating
     *
     * @param string|null $score The rating of something
     *
     * @return self
     */
    public function setRating(?string $score)
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
     * @return string|null rating or null if no rating has been set
     */
    public function getRating() : ?string
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
     * @return string|null Default "rating" value or null if no default value is available
     */
    public function getDefaultRating() : ?string
    {
        return null;
    }
}
