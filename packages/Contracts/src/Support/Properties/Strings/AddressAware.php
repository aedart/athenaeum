<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Address Aware
 *
 * Component is aware of string "address"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface AddressAware
{
    /**
     * Set address
     *
     * @param string|null $address Address to someone or something
     *
     * @return self
     */
    public function setAddress(string|null $address): static;

    /**
     * Get address
     *
     * If no address value set, method
     * sets and returns a default address.
     *
     * @see getDefaultAddress()
     *
     * @return string|null address or null if no address has been set
     */
    public function getAddress(): string|null;

    /**
     * Check if address has been set
     *
     * @return bool True if address has been set, false if not
     */
    public function hasAddress(): bool;

    /**
     * Get a default address value, if any is available
     *
     * @return string|null Default address value or null if no default value is available
     */
    public function getDefaultAddress(): string|null;
}
