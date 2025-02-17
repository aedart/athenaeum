<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Ip v6 Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\IpV6Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait IpV6Trait
{
    /**
     * IPv6 address
     *
     * @var string|null
     */
    protected string|null $ipV6 = null;

    /**
     * Set ip v6
     *
     * @param string|null $address IPv6 address
     *
     * @return self
     */
    public function setIpV6(string|null $address): static
    {
        $this->ipV6 = $address;

        return $this;
    }

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
    public function getIpV6(): string|null
    {
        if (!$this->hasIpV6()) {
            $this->setIpV6($this->getDefaultIpV6());
        }
        return $this->ipV6;
    }

    /**
     * Check if ip v6 has been set
     *
     * @return bool True if ip v6 has been set, false if not
     */
    public function hasIpV6(): bool
    {
        return isset($this->ipV6);
    }

    /**
     * Get a default ip v6 value, if any is available
     *
     * @return string|null Default ip v6 value or null if no default value is available
     */
    public function getDefaultIpV6(): string|null
    {
        return null;
    }
}
