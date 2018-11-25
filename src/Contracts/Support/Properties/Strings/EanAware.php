<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Ean Aware
 *
 * Component is aware of string "ean"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface EanAware
{
    /**
     * Set ean
     *
     * @param string|null $ean International Article Number (EAN)
     *
     * @return self
     */
    public function setEan(?string $ean);

    /**
     * Get ean
     *
     * If no "ean" value set, method
     * sets and returns a default "ean".
     *
     * @see getDefaultEan()
     *
     * @return string|null ean or null if no ean has been set
     */
    public function getEan() : ?string;

    /**
     * Check if "ean" has been set
     *
     * @return bool True if "ean" has been set, false if not
     */
    public function hasEan() : bool;

    /**
     * Get a default "ean" value, if any is available
     *
     * @return string|null Default "ean" value or null if no default value is available
     */
    public function getDefaultEan() : ?string;
}
