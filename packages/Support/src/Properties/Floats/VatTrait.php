<?php

namespace Aedart\Support\Properties\Floats;

/**
 * Vat Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\VatAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait VatTrait
{
    /**
     * Value Added Tac (VAT), formatted amount or rate
     *
     * @var float|null
     */
    protected ?float $vat = null;

    /**
     * Set vat
     *
     * @param float|null $amount Value Added Tac (VAT), formatted amount or rate
     *
     * @return self
     */
    public function setVat(?float $amount)
    {
        $this->vat = $amount;

        return $this;
    }

    /**
     * Get vat
     *
     * If no "vat" value set, method
     * sets and returns a default "vat".
     *
     * @see getDefaultVat()
     *
     * @return float|null vat or null if no vat has been set
     */
    public function getVat() : ?float
    {
        if ( ! $this->hasVat()) {
            $this->setVat($this->getDefaultVat());
        }
        return $this->vat;
    }

    /**
     * Check if "vat" has been set
     *
     * @return bool True if "vat" has been set, false if not
     */
    public function hasVat() : bool
    {
        return isset($this->vat);
    }

    /**
     * Get a default "vat" value, if any is available
     *
     * @return float|null Default "vat" value or null if no default value is available
     */
    public function getDefaultVat() : ?float
    {
        return null;
    }
}
