<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Vat Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\VatAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait VatTrait
{
    /**
     * Value Added Tac (VAT), formatted amount or rate
     *
     * @var string|null
     */
    protected string|null $vat = null;

    /**
     * Set vat
     *
     * @param string|null $amount Value Added Tac (VAT), formatted amount or rate
     *
     * @return self
     */
    public function setVat(string|null $amount): static
    {
        $this->vat = $amount;

        return $this;
    }

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
    public function getVat(): string|null
    {
        if (!$this->hasVat()) {
            $this->setVat($this->getDefaultVat());
        }
        return $this->vat;
    }

    /**
     * Check if vat has been set
     *
     * @return bool True if vat has been set, false if not
     */
    public function hasVat(): bool
    {
        return isset($this->vat);
    }

    /**
     * Get a default vat value, if any is available
     *
     * @return string|null Default vat value or null if no default value is available
     */
    public function getDefaultVat(): string|null
    {
        return null;
    }
}
