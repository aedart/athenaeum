<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Brand Aware
 *
 * Component is aware of string "brand"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface BrandAware
{
    /**
     * Set brand
     *
     * @param string|null $identifier Name or identifier of a brand that is associated with a product or service
     *
     * @return self
     */
    public function setBrand(string|null $identifier): static;

    /**
     * Get brand
     *
     * If no brand value set, method
     * sets and returns a default brand.
     *
     * @see getDefaultBrand()
     *
     * @return string|null brand or null if no brand has been set
     */
    public function getBrand(): string|null;

    /**
     * Check if brand has been set
     *
     * @return bool True if brand has been set, false if not
     */
    public function hasBrand(): bool;

    /**
     * Get a default brand value, if any is available
     *
     * @return string|null Default brand value or null if no default value is available
     */
    public function getDefaultBrand(): string|null;
}
