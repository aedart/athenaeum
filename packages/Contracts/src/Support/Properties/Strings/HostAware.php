<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Host Aware
 *
 * Component is aware of string "host"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface HostAware
{
    /**
     * Set host
     *
     * @param string|null $identifier Identifier of a host
     *
     * @return self
     */
    public function setHost(string|null $identifier): static;

    /**
     * Get host
     *
     * If no host value set, method
     * sets and returns a default host.
     *
     * @see getDefaultHost()
     *
     * @return string|null host or null if no host has been set
     */
    public function getHost(): string|null;

    /**
     * Check if host has been set
     *
     * @return bool True if host has been set, false if not
     */
    public function hasHost(): bool;

    /**
     * Get a default host value, if any is available
     *
     * @return string|null Default host value or null if no default value is available
     */
    public function getDefaultHost(): string|null;
}
