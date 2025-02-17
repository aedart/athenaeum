<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Ip v6 Aware
 *
 * Component is aware of string "ip v6"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface IpV6Aware
{
    /**
     * Set ip v6
     *
     * @param string|null $address IPv6 address
     *
     * @return self
     */
    public function setIpV6(string|null $address): static;

    /**
     * Get ip v6
     *
     * If no ip v6 value set, method
     * sets and returns a default ip v6.
     *
     * @see getDefaultIpV6()
     *
     * @return string|null ip v6 or null if no ip v6 has been set
     */
    public function getIpV6(): string|null;

    /**
     * Check if ip v6 has been set
     *
     * @return bool True if ip v6 has been set, false if not
     */
    public function hasIpV6(): bool;

    /**
     * Get a default ip v6 value, if any is available
     *
     * @return string|null Default ip v6 value or null if no default value is available
     */
    public function getDefaultIpV6(): string|null;
}
