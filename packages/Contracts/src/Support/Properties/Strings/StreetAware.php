<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Street Aware
 *
 * Component is aware of string "street"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface StreetAware
{
    /**
     * Set street
     *
     * @param string|null $address Full street address, which might include building or apartment number(s)
     *
     * @return self
     */
    public function setStreet(string|null $address): static;

    /**
     * Get street
     *
     * If no street value set, method
     * sets and returns a default street.
     *
     * @see getDefaultStreet()
     *
     * @return string|null street or null if no street has been set
     */
    public function getStreet(): string|null;

    /**
     * Check if street has been set
     *
     * @return bool True if street has been set, false if not
     */
    public function hasStreet(): bool;

    /**
     * Get a default street value, if any is available
     *
     * @return string|null Default street value or null if no default value is available
     */
    public function getDefaultStreet(): string|null;
}
