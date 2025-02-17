<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Manufacturer Aware
 *
 * Component is aware of string "manufacturer"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ManufacturerAware
{
    /**
     * Set manufacturer
     *
     * @param string|null $identifier Name or identifier of a manufacturer
     *
     * @return self
     */
    public function setManufacturer(string|null $identifier): static;

    /**
     * Get manufacturer
     *
     * If no manufacturer value set, method
     * sets and returns a default manufacturer.
     *
     * @see getDefaultManufacturer()
     *
     * @return string|null manufacturer or null if no manufacturer has been set
     */
    public function getManufacturer(): string|null;

    /**
     * Check if manufacturer has been set
     *
     * @return bool True if manufacturer has been set, false if not
     */
    public function hasManufacturer(): bool;

    /**
     * Get a default manufacturer value, if any is available
     *
     * @return string|null Default manufacturer value or null if no default value is available
     */
    public function getDefaultManufacturer(): string|null;
}
