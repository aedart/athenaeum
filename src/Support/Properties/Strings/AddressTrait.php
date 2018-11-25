<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Address Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\AddressAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait AddressTrait
{
    /**
     * Address to someone or something
     *
     * @var string|null
     */
    protected $address = null;

    /**
     * Set address
     *
     * @param string|null $address Address to someone or something
     *
     * @return self
     */
    public function setAddress(?string $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * If no "address" value set, method
     * sets and returns a default "address".
     *
     * @see getDefaultAddress()
     *
     * @return string|null address or null if no address has been set
     */
    public function getAddress() : ?string
    {
        if ( ! $this->hasAddress()) {
            $this->setAddress($this->getDefaultAddress());
        }
        return $this->address;
    }

    /**
     * Check if "address" has been set
     *
     * @return bool True if "address" has been set, false if not
     */
    public function hasAddress() : bool
    {
        return isset($this->address);
    }

    /**
     * Get a default "address" value, if any is available
     *
     * @return string|null Default "address" value or null if no default value is available
     */
    public function getDefaultAddress() : ?string
    {
        return null;
    }
}
