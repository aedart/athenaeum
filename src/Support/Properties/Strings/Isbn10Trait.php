<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Isbn10 Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\Isbn10Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait Isbn10Trait
{
    /**
     * International Standard Book Number (ISBN), 10-digits
     *
     * @var string|null
     */
    protected $isbn10 = null;

    /**
     * Set isbn10
     *
     * @param string|null $isbn10 International Standard Book Number (ISBN), 10-digits
     *
     * @return self
     */
    public function setIsbn10(?string $isbn10)
    {
        $this->isbn10 = $isbn10;

        return $this;
    }

    /**
     * Get isbn10
     *
     * If no "isbn10" value set, method
     * sets and returns a default "isbn10".
     *
     * @see getDefaultIsbn10()
     *
     * @return string|null isbn10 or null if no isbn10 has been set
     */
    public function getIsbn10() : ?string
    {
        if ( ! $this->hasIsbn10()) {
            $this->setIsbn10($this->getDefaultIsbn10());
        }
        return $this->isbn10;
    }

    /**
     * Check if "isbn10" has been set
     *
     * @return bool True if "isbn10" has been set, false if not
     */
    public function hasIsbn10() : bool
    {
        return isset($this->isbn10);
    }

    /**
     * Get a default "isbn10" value, if any is available
     *
     * @return string|null Default "isbn10" value or null if no default value is available
     */
    public function getDefaultIsbn10() : ?string
    {
        return null;
    }
}
