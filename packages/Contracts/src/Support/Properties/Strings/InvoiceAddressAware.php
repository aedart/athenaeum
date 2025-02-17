<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Invoice address Aware
 *
 * Component is aware of string "invoice address"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface InvoiceAddressAware
{
    /**
     * Set invoice address
     *
     * @param string|null $address Invoice Address. Can be formatted.
     *
     * @return self
     */
    public function setInvoiceAddress(string|null $address): static;

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
    public function getInvoiceAddress(): string|null;

    /**
     * Check if invoice address has been set
     *
     * @return bool True if invoice address has been set, false if not
     */
    public function hasInvoiceAddress(): bool;

    /**
     * Get a default invoice address value, if any is available
     *
     * @return string|null Default invoice address value or null if no default value is available
     */
    public function getDefaultInvoiceAddress(): string|null;
}
