<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Vendor Aware
 *
 * Component is aware of string "vendor"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface VendorAware
{
    /**
     * Set vendor
     *
     * @param string|null $vendor Name or path of a vendor
     *
     * @return self
     */
    public function setVendor(string|null $vendor): static;

    /**
     * Get vendor
     *
     * If no vendor value set, method
     * sets and returns a default vendor.
     *
     * @see getDefaultVendor()
     *
     * @return string|null vendor or null if no vendor has been set
     */
    public function getVendor(): string|null;

    /**
     * Check if vendor has been set
     *
     * @return bool True if vendor has been set, false if not
     */
    public function hasVendor(): bool;

    /**
     * Get a default vendor value, if any is available
     *
     * @return string|null Default vendor value or null if no default value is available
     */
    public function getDefaultVendor(): string|null;
}
