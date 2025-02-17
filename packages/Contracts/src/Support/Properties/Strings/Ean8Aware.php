<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Ean8 Aware
 *
 * Component is aware of string "ean8"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface Ean8Aware
{
    /**
     * Set ean8
     *
     * @param string|null $ean8 International Article Number (EAN), 8-digit
     *
     * @return self
     */
    public function setEan8(string|null $ean8): static;

    /**
     * Get ean8
     *
     * If no ean8 value set, method
     * sets and returns a default ean8.
     *
     * @see getDefaultEan8()
     *
     * @return string|null ean8 or null if no ean8 has been set
     */
    public function getEan8(): string|null;

    /**
     * Check if ean8 has been set
     *
     * @return bool True if ean8 has been set, false if not
     */
    public function hasEan8(): bool;

    /**
     * Get a default ean8 value, if any is available
     *
     * @return string|null Default ean8 value or null if no default value is available
     */
    public function getDefaultEan8(): string|null;
}
