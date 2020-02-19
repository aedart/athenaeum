<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Isbn10 Aware
 *
 * Component is aware of string "isbn10"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface Isbn10Aware
{
    /**
     * Set isbn10
     *
     * @param string|null $isbn10 International Standard Book Number (ISBN), 10-digits
     *
     * @return self
     */
    public function setIsbn10(?string $isbn10);

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
    public function getIsbn10(): ?string;

    /**
     * Check if "isbn10" has been set
     *
     * @return bool True if "isbn10" has been set, false if not
     */
    public function hasIsbn10(): bool;

    /**
     * Get a default "isbn10" value, if any is available
     *
     * @return string|null Default "isbn10" value or null if no default value is available
     */
    public function getDefaultIsbn10(): ?string;
}
