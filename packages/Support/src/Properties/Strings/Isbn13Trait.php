<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Isbn13 Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\Isbn13Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait Isbn13Trait
{
    /**
     * International Standard Book Number (ISBN), 13-digits
     *
     * @var string|null
     */
    protected string|null $isbn13 = null;

    /**
     * Set isbn13
     *
     * @param string|null $ibn13 International Standard Book Number (ISBN), 13-digits
     *
     * @return self
     */
    public function setIsbn13(string|null $ibn13): static
    {
        $this->isbn13 = $ibn13;

        return $this;
    }

    /**
     * Get isbn13
     *
     * If no isbn13 value set, method
     * sets and returns a default isbn13.
     *
     * @see getDefaultIsbn13()
     *
     * @return string|null isbn13 or null if no isbn13 has been set
     */
    public function getIsbn13(): string|null
    {
        if (!$this->hasIsbn13()) {
            $this->setIsbn13($this->getDefaultIsbn13());
        }
        return $this->isbn13;
    }

    /**
     * Check if isbn13 has been set
     *
     * @return bool True if isbn13 has been set, false if not
     */
    public function hasIsbn13(): bool
    {
        return isset($this->isbn13);
    }

    /**
     * Get a default isbn13 value, if any is available
     *
     * @return string|null Default isbn13 value or null if no default value is available
     */
    public function getDefaultIsbn13(): string|null
    {
        return null;
    }
}
