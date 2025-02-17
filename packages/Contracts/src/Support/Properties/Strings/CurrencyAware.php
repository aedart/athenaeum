<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Currency Aware
 *
 * Component is aware of string "currency"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface CurrencyAware
{
    /**
     * Set currency
     *
     * @param string|null $identifier Name, code or other identifier of currency
     *
     * @return self
     */
    public function setCurrency(string|null $identifier): static;

    /**
     * Get currency
     *
     * If no currency value set, method
     * sets and returns a default currency.
     *
     * @see getDefaultCurrency()
     *
     * @return string|null currency or null if no currency has been set
     */
    public function getCurrency(): string|null;

    /**
     * Check if currency has been set
     *
     * @return bool True if currency has been set, false if not
     */
    public function hasCurrency(): bool;

    /**
     * Get a default currency value, if any is available
     *
     * @return string|null Default currency value or null if no default value is available
     */
    public function getDefaultCurrency(): string|null;
}
