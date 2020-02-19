<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Vat Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\VatAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait VatTrait
{
    /**
     * Value Added Tac (VAT), formatted amount or rate
     *
     * @var int|null
     */
    protected ?int $vat = null;

    /**
     * Set vat
     *
     * @param int|null $amount Value Added Tac (VAT), formatted amount or rate
     *
     * @return self
     */
    public function setVat(?int $amount)
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
     * @return int|null vat or null if no vat has been set
     */
    public function getVat(): ?int
    {
        if (!$this->hasVat()) {
            $this->setVat($this->getDefaultVat());
        }
        return $this->vat;
    }

    /**
     * Check if "vat" has been set
     *
     * @return bool True if "vat" has been set, false if not
     */
    public function hasVat(): bool
    {
        return isset($this->vat);
    }

    /**
     * Get a default "vat" value, if any is available
     *
     * @return int|null Default "vat" value or null if no default value is available
     */
    public function getDefaultVat(): ?int
    {
        return null;
    }
}
