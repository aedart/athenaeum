<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Vat Aware
 *
 * Component is aware of string "vat"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface VatAware
{
    /**
     * Set vat
     *
     * @param string|null $amount Value Added Tac (VAT), formatted amount or rate
     *
     * @return self
     */
    public function setVat(string|null $amount): static;

    /**
     * Get vat
     *
     * If no vat value set, method
     * sets and returns a default vat.
     *
     * @see getDefaultVat()
     *
     * @return string|null vat or null if no vat has been set
     */
    public function getVat(): string|null;

    /**
     * Check if vat has been set
     *
     * @return bool True if vat has been set, false if not
     */
    public function hasVat(): bool;

    /**
     * Get a default vat value, if any is available
     *
     * @return string|null Default vat value or null if no default value is available
     */
    public function getDefaultVat(): string|null;
}
