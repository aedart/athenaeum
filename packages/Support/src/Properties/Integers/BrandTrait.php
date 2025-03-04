<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Brand Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\BrandAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait BrandTrait
{
    /**
     * Name or identifier of a brand that is associated with a product or service
     *
     * @var int|null
     */
    protected int|null $brand = null;

    /**
     * Set brand
     *
     * @param int|null $identifier Name or identifier of a brand that is associated with a product or service
     *
     * @return self
     */
    public function setBrand(int|null $identifier): static
    {
        $this->brand = $identifier;

        return $this;
    }

    /**
     * Get brand
     *
     * If no brand value set, method
     * sets and returns a default brand.
     *
     * @see getDefaultBrand()
     *
     * @return int|null brand or null if no brand has been set
     */
    public function getBrand(): int|null
    {
        if (!$this->hasBrand()) {
            $this->setBrand($this->getDefaultBrand());
        }
        return $this->brand;
    }

    /**
     * Check if brand has been set
     *
     * @return bool True if brand has been set, false if not
     */
    public function hasBrand(): bool
    {
        return isset($this->brand);
    }

    /**
     * Get a default brand value, if any is available
     *
     * @return int|null Default brand value or null if no default value is available
     */
    public function getDefaultBrand(): int|null
    {
        return null;
    }
}
