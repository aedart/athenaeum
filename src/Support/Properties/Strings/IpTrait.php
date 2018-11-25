<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Ip Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\IpAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait IpTrait
{
    /**
     * IP address
     *
     * @var string|null
     */
    protected $ip = null;

    /**
     * Set ip
     *
     * @param string|null $address IP address
     *
     * @return self
     */
    public function setIp(?string $address)
    {
        $this->ip = $address;

        return $this;
    }

    /**
     * Get ip
     *
     * If no "ip" value set, method
     * sets and returns a default "ip".
     *
     * @see getDefaultIp()
     *
     * @return string|null ip or null if no ip has been set
     */
    public function getIp() : ?string
    {
        if ( ! $this->hasIp()) {
            $this->setIp($this->getDefaultIp());
        }
        return $this->ip;
    }

    /**
     * Check if "ip" has been set
     *
     * @return bool True if "ip" has been set, false if not
     */
    public function hasIp() : bool
    {
        return isset($this->ip);
    }

    /**
     * Get a default "ip" value, if any is available
     *
     * @return string|null Default "ip" value or null if no default value is available
     */
    public function getDefaultIp() : ?string
    {
        return null;
    }
}
