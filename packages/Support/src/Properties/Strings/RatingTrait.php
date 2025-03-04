<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
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
    protected string|null $rating = null;

    /**
     * Set rating
     *
     * @param string|null $score The rating of something
     *
     * @return self
     */
    public function setRating(string|null $score): static
    {
        $this->rating = $score;

        return $this;
    }

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
    public function getRating(): string|null
    {
        if (!$this->hasRating()) {
            $this->setRating($this->getDefaultRating());
        }
        return $this->rating;
    }

    /**
     * Check if rating has been set
     *
     * @return bool True if rating has been set, false if not
     */
    public function hasRating(): bool
    {
        return isset($this->rating);
    }

    /**
     * Get a default rating value, if any is available
     *
     * @return string|null Default rating value or null if no default value is available
     */
    public function getDefaultRating(): string|null
    {
        return null;
    }
}
