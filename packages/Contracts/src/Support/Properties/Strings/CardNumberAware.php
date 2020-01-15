<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Card number Aware
 *
 * Component is aware of string "card number"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface CardNumberAware
{
    /**
     * Set card number
     *
     * @param string|null $number Numeric or Alphanumeric card number, e.g. for credit cards or other types of cards
     *
     * @return self
     */
    public function setCardNumber(?string $number);

    /**
     * Get card number
     *
     * If no "card number" value set, method
     * sets and returns a default "card number".
     *
     * @see getDefaultCardNumber()
     *
     * @return string|null card number or null if no card number has been set
     */
    public function getCardNumber() : ?string;

    /**
     * Check if "card number" has been set
     *
     * @return bool True if "card number" has been set, false if not
     */
    public function hasCardNumber() : bool;

    /**
     * Get a default "card number" value, if any is available
     *
     * @return string|null Default "card number" value or null if no default value is available
     */
    public function getDefaultCardNumber() : ?string;
}
