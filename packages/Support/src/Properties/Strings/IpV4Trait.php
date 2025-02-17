<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Ip v4 Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\IpV4Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait IpV4Trait
{
    /**
     * IPv4 address
     *
     * @var string|null
     */
    protected string|null $ipV4 = null;

    /**
     * Set ip v4
     *
     * @param string|null $address IPv4 address
     *
     * @return self
     */
    public function setIpV4(string|null $address): static
    {
        $this->ipV4 = $address;

        return $this;
    }

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
    public function getIpV4(): string|null
    {
        if (!$this->hasIpV4()) {
            $this->setIpV4($this->getDefaultIpV4());
        }
        return $this->ipV4;
    }

    /**
     * Check if ip v4 has been set
     *
     * @return bool True if ip v4 has been set, false if not
     */
    public function hasIpV4(): bool
    {
        return isset($this->ipV4);
    }

    /**
     * Get a default ip v4 value, if any is available
     *
     * @return string|null Default ip v4 value or null if no default value is available
     */
    public function getDefaultIpV4(): string|null
    {
        return null;
    }
}
