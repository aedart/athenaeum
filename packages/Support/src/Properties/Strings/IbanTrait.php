<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Iban Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\IbanAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait IbanTrait
{
    /**
     * International Bank Account Number (IBAN)
     *
     * @var string|null
     */
    protected string|null $iban = null;

    /**
     * Set iban
     *
     * @param string|null $number International Bank Account Number (IBAN)
     *
     * @return self
     */
    public function setIban(string|null $number): static
    {
        $this->iban = $number;

        return $this;
    }

    /**
     * Get iban
     *
     * If no iban value set, method
     * sets and returns a default iban.
     *
     * @see getDefaultIban()
     *
     * @return string|null iban or null if no iban has been set
     */
    public function getIban(): string|null
    {
        if (!$this->hasIban()) {
            $this->setIban($this->getDefaultIban());
        }
        return $this->iban;
    }

    /**
     * Check if iban has been set
     *
     * @return bool True if iban has been set, false if not
     */
    public function hasIban(): bool
    {
        return isset($this->iban);
    }

    /**
     * Get a default iban value, if any is available
     *
     * @return string|null Default iban value or null if no default value is available
     */
    public function getDefaultIban(): string|null
    {
        return null;
    }
}
