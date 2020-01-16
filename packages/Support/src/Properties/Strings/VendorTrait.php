<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Vendor Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\VendorAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait VendorTrait
{
    /**
     * Name or path of a vendor
     *
     * @var string|null
     */
    protected ?string $vendor = null;

    /**
     * Set vendor
     *
     * @param string|null $vendor Name or path of a vendor
     *
     * @return self
     */
    public function setVendor(?string $vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * If no "vendor" value set, method
     * sets and returns a default "vendor".
     *
     * @see getDefaultVendor()
     *
     * @return string|null vendor or null if no vendor has been set
     */
    public function getVendor() : ?string
    {
        if ( ! $this->hasVendor()) {
            $this->setVendor($this->getDefaultVendor());
        }
        return $this->vendor;
    }

    /**
     * Check if "vendor" has been set
     *
     * @return bool True if "vendor" has been set, false if not
     */
    public function hasVendor() : bool
    {
        return isset($this->vendor);
    }

    /**
     * Get a default "vendor" value, if any is available
     *
     * @return string|null Default "vendor" value or null if no default value is available
     */
    public function getDefaultVendor() : ?string
    {
        return null;
    }
}
