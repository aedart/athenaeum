<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Card number Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\CardNumberAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait CardNumberTrait
{
    /**
     * Numeric or Alphanumeric card number, e.g. for credit cards or other types of cards
     *
     * @var string|null
     */
    protected string|null $cardNumber = null;

    /**
     * Set card number
     *
     * @param string|null $number Numeric or Alphanumeric card number, e.g. for credit cards or other types of cards
     *
     * @return self
     */
    public function setCardNumber(string|null $number): static
    {
        $this->cardNumber = $number;

        return $this;
    }

    /**
     * Get card number
     *
     * If no card number value set, method
     * sets and returns a default card number.
     *
     * @see getDefaultCardNumber()
     *
     * @return string|null card number or null if no card number has been set
     */
    public function getCardNumber(): string|null
    {
        if (!$this->hasCardNumber()) {
            $this->setCardNumber($this->getDefaultCardNumber());
        }
        return $this->cardNumber;
    }

    /**
     * Check if card number has been set
     *
     * @return bool True if card number has been set, false if not
     */
    public function hasCardNumber(): bool
    {
        return isset($this->cardNumber);
    }

    /**
     * Get a default card number value, if any is available
     *
     * @return string|null Default card number value or null if no default value is available
     */
    public function getDefaultCardNumber(): string|null
    {
        return null;
    }
}
