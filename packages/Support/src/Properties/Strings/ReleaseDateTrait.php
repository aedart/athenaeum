<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Release date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ReleaseDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ReleaseDateTrait
{
    /**
     * Date of planned release
     *
     * @var string|null
     */
    protected ?string $releaseDate = null;

    /**
     * Set release date
     *
     * @param string|null $date Date of planned release
     *
     * @return self
     */
    public function setReleaseDate(?string $date)
    {
        $this->releaseDate = $date;

        return $this;
    }

    /**
     * Get release date
     *
     * If no "release date" value set, method
     * sets and returns a default "release date".
     *
     * @see getDefaultReleaseDate()
     *
     * @return string|null release date or null if no release date has been set
     */
    public function getReleaseDate(): ?string
    {
        if (!$this->hasReleaseDate()) {
            $this->setReleaseDate($this->getDefaultReleaseDate());
        }
        return $this->releaseDate;
    }

    /**
     * Check if "release date" has been set
     *
     * @return bool True if "release date" has been set, false if not
     */
    public function hasReleaseDate(): bool
    {
        return isset($this->releaseDate);
    }

    /**
     * Get a default "release date" value, if any is available
     *
     * @return string|null Default "release date" value or null if no default value is available
     */
    public function getDefaultReleaseDate(): ?string
    {
        return null;
    }
}
