<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Vat Aware
 *
 * Component is aware of int "vat"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface VatAware
{
    /**
     * Set vat
     *
     * @param int|null $amount Value Added Tac (VAT), formatted amount or rate
     *
     * @return self
     */
    public function setVat(int|null $amount): static;

    /**
     * Get vat
     *
     * If no vat value set, method
     * sets and returns a default vat.
     *
     * @see getDefaultVat()
     *
     * @return int|null vat or null if no vat has been set
     */
    public function getVat(): int|null;

    /**
     * Check if vat has been set
     *
     * @return bool True if vat has been set, false if not
     */
    public function hasVat(): bool;

    /**
     * Get a default vat value, if any is available
     *
     * @return int|null Default vat value or null if no default value is available
     */
    public function getDefaultVat(): int|null;
}
