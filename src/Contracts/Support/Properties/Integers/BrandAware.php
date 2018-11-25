<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * Brand Aware
 *
 * Component is aware of int "brand"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface BrandAware
{
    /**
     * Set brand
     *
     * @param int|null $identifier Name or identifier of a brand that is associated with a product or service
     *
     * @return self
     */
    public function setBrand(?int $identifier);

    /**
     * Get brand
     *
     * If no "brand" value set, method
     * sets and returns a default "brand".
     *
     * @see getDefaultBrand()
     *
     * @return int|null brand or null if no brand has been set
     */
    public function getBrand() : ?int;

    /**
     * Check if "brand" has been set
     *
     * @return bool True if "brand" has been set, false if not
     */
    public function hasBrand() : bool;

    /**
     * Get a default "brand" value, if any is available
     *
     * @return int|null Default "brand" value or null if no default value is available
     */
    public function getDefaultBrand() : ?int;
}
