<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Purchase date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\PurchaseDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait PurchaseDateTrait
{
    /**
     * Date of planned purchase
     *
     * @var string|null
     */
    protected string|null $purchaseDate = null;

    /**
     * Set purchase date
     *
     * @param string|null $date Date of planned purchase
     *
     * @return self
     */
    public function setPurchaseDate(string|null $date): static
    {
        $this->purchaseDate = $date;

        return $this;
    }

    /**
     * Get purchase date
     *
     * If no purchase date value set, method
     * sets and returns a default purchase date.
     *
     * @see getDefaultPurchaseDate()
     *
     * @return string|null purchase date or null if no purchase date has been set
     */
    public function getPurchaseDate(): string|null
    {
        if (!$this->hasPurchaseDate()) {
            $this->setPurchaseDate($this->getDefaultPurchaseDate());
        }
        return $this->purchaseDate;
    }

    /**
     * Check if purchase date has been set
     *
     * @return bool True if purchase date has been set, false if not
     */
    public function hasPurchaseDate(): bool
    {
        return isset($this->purchaseDate);
    }

    /**
     * Get a default purchase date value, if any is available
     *
     * @return string|null Default purchase date value or null if no default value is available
     */
    public function getDefaultPurchaseDate(): string|null
    {
        return null;
    }
}
