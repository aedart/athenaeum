<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Invoice address Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\InvoiceAddressAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait InvoiceAddressTrait
{
    /**
     * Invoice Address. Can be formatted.
     *
     * @var string|null
     */
    protected string|null $invoiceAddress = null;

    /**
     * Set invoice address
     *
     * @param string|null $address Invoice Address. Can be formatted.
     *
     * @return self
     */
    public function setInvoiceAddress(string|null $address): static
    {
        $this->invoiceAddress = $address;

        return $this;
    }

    /**
     * Get invoice address
     *
     * If no invoice address value set, method
     * sets and returns a default invoice address.
     *
     * @see getDefaultInvoiceAddress()
     *
     * @return string|null invoice address or null if no invoice address has been set
     */
    public function getInvoiceAddress(): string|null
    {
        if (!$this->hasInvoiceAddress()) {
            $this->setInvoiceAddress($this->getDefaultInvoiceAddress());
        }
        return $this->invoiceAddress;
    }

    /**
     * Check if invoice address has been set
     *
     * @return bool True if invoice address has been set, false if not
     */
    public function hasInvoiceAddress(): bool
    {
        return isset($this->invoiceAddress);
    }

    /**
     * Get a default invoice address value, if any is available
     *
     * @return string|null Default invoice address value or null if no default value is available
     */
    public function getDefaultInvoiceAddress(): string|null
    {
        return null;
    }
}
