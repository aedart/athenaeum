<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Ip v4 Aware
 *
 * Component is aware of string "ip v4"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface IpV4Aware
{
    /**
     * Set ip v4
     *
     * @param string|null $address IPv4 address
     *
     * @return self
     */
    public function setIpV4(string|null $address): static;

    /**
     * Get ip v4
     *
     * If no ip v4 value set, method
     * sets and returns a default ip v4.
     *
     * @see getDefaultIpV4()
     *
     * @return string|null ip v4 or null if no ip v4 has been set
     */
    public function getIpV4(): string|null;

    /**
     * Check if ip v4 has been set
     *
     * @return bool True if ip v4 has been set, false if not
     */
    public function hasIpV4(): bool;

    /**
     * Get a default ip v4 value, if any is available
     *
     * @return string|null Default ip v4 value or null if no default value is available
     */
    public function getDefaultIpV4(): string|null;
}
