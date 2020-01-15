<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Purchase date Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\PurchaseDateAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait PurchaseDateTrait
{
    /**
     * Date of planned purchase
     *
     * @var int|null
     */
    protected ?int $purchaseDate = null;

    /**
     * Set purchase date
     *
     * @param int|null $date Date of planned purchase
     *
     * @return self
     */
    public function setPurchaseDate(?int $date)
    {
        $this->purchaseDate = $date;

        return $this;
    }

    /**
     * Get purchase date
     *
     * If no "purchase date" value set, method
     * sets and returns a default "purchase date".
     *
     * @see getDefaultPurchaseDate()
     *
     * @return int|null purchase date or null if no purchase date has been set
     */
    public function getPurchaseDate() : ?int
    {
        if ( ! $this->hasPurchaseDate()) {
            $this->setPurchaseDate($this->getDefaultPurchaseDate());
        }
        return $this->purchaseDate;
    }

    /**
     * Check if "purchase date" has been set
     *
     * @return bool True if "purchase date" has been set, false if not
     */
    public function hasPurchaseDate() : bool
    {
        return isset($this->purchaseDate);
    }

    /**
     * Get a default "purchase date" value, if any is available
     *
     * @return int|null Default "purchase date" value or null if no default value is available
     */
    public function getDefaultPurchaseDate() : ?int
    {
        return null;
    }
}
