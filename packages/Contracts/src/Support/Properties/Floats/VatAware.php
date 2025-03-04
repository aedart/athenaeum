<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Vat Aware
 *
 * Component is aware of float "vat"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface VatAware
{
    /**
     * Set vat
     *
     * @param float|null $amount Value Added Tac (VAT), formatted amount or rate
     *
     * @return self
     */
    public function setVat(float|null $amount): static;

    /**
     * Get vat
     *
     * If no vat value set, method
     * sets and returns a default vat.
     *
     * @see getDefaultVat()
     *
     * @return float|null vat or null if no vat has been set
     */
    public function getVat(): float|null;

    /**
     * Check if vat has been set
     *
     * @return bool True if vat has been set, false if not
     */
    public function hasVat(): bool;

    /**
     * Get a default vat value, if any is available
     *
     * @return float|null Default vat value or null if no default value is available
     */
    public function getDefaultVat(): float|null;
}
