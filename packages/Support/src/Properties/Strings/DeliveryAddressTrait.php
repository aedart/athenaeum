<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Delivery address Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DeliveryAddressAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DeliveryAddressTrait
{
    /**
     * Delivery address
     *
     * @var string|null
     */
    protected string|null $deliveryAddress = null;

    /**
     * Set delivery address
     *
     * @param string|null $address Delivery address
     *
     * @return self
     */
    public function setDeliveryAddress(string|null $address): static
    {
        $this->deliveryAddress = $address;

        return $this;
    }

    /**
     * Get delivery address
     *
     * If no delivery address value set, method
     * sets and returns a default delivery address.
     *
     * @see getDefaultDeliveryAddress()
     *
     * @return string|null delivery address or null if no delivery address has been set
     */
    public function getDeliveryAddress(): string|null
    {
        if (!$this->hasDeliveryAddress()) {
            $this->setDeliveryAddress($this->getDefaultDeliveryAddress());
        }
        return $this->deliveryAddress;
    }

    /**
     * Check if delivery address has been set
     *
     * @return bool True if delivery address has been set, false if not
     */
    public function hasDeliveryAddress(): bool
    {
        return isset($this->deliveryAddress);
    }

    /**
     * Get a default delivery address value, if any is available
     *
     * @return string|null Default delivery address value or null if no default value is available
     */
    public function getDefaultDeliveryAddress(): string|null
    {
        return null;
    }
}
