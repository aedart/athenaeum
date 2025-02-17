<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Release date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\ReleaseDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait ReleaseDateTrait
{
    /**
     * Date of planned release
     *
     * @var int|null
     */
    protected int|null $releaseDate = null;

    /**
     * Set release date
     *
     * @param int|null $date Date of planned release
     *
     * @return self
     */
    public function setReleaseDate(int|null $date): static
    {
        $this->releaseDate = $date;

        return $this;
    }

    /**
     * Get release date
     *
     * If no release date value set, method
     * sets and returns a default release date.
     *
     * @see getDefaultReleaseDate()
     *
     * @return int|null release date or null if no release date has been set
     */
    public function getReleaseDate(): int|null
    {
        if (!$this->hasReleaseDate()) {
            $this->setReleaseDate($this->getDefaultReleaseDate());
        }
        return $this->releaseDate;
    }

    /**
     * Check if release date has been set
     *
     * @return bool True if release date has been set, false if not
     */
    public function hasReleaseDate(): bool
    {
        return isset($this->releaseDate);
    }

    /**
     * Get a default release date value, if any is available
     *
     * @return int|null Default release date value or null if no default value is available
     */
    public function getDefaultReleaseDate(): int|null
    {
        return null;
    }
}
