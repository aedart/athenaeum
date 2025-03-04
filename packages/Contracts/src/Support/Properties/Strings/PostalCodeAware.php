<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Postal code Aware
 *
 * Component is aware of string "postal code"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface PostalCodeAware
{
    /**
     * Set postal code
     *
     * @param string|null $code Numeric or Alphanumeric postal code (zip code)
     *
     * @return self
     */
    public function setPostalCode(string|null $code): static;

    /**
     * Get postal code
     *
     * If no postal code value set, method
     * sets and returns a default postal code.
     *
     * @see getDefaultPostalCode()
     *
     * @return string|null postal code or null if no postal code has been set
     */
    public function getPostalCode(): string|null;

    /**
     * Check if postal code has been set
     *
     * @return bool True if postal code has been set, false if not
     */
    public function hasPostalCode(): bool;

    /**
     * Get a default postal code value, if any is available
     *
     * @return string|null Default postal code value or null if no default value is available
     */
    public function getDefaultPostalCode(): string|null;
}
