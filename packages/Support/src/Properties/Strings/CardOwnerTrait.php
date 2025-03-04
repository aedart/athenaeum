<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Card owner Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\CardOwnerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait CardOwnerTrait
{
    /**
     * Name of the card owner (cardholder)
     *
     * @var string|null
     */
    protected string|null $cardOwner = null;

    /**
     * Set card owner
     *
     * @param string|null $name Name of the card owner (cardholder)
     *
     * @return self
     */
    public function setCardOwner(string|null $name): static
    {
        $this->cardOwner = $name;

        return $this;
    }

    /**
     * Get card owner
     *
     * If no card owner value set, method
     * sets and returns a default card owner.
     *
     * @see getDefaultCardOwner()
     *
     * @return string|null card owner or null if no card owner has been set
     */
    public function getCardOwner(): string|null
    {
        if (!$this->hasCardOwner()) {
            $this->setCardOwner($this->getDefaultCardOwner());
        }
        return $this->cardOwner;
    }

    /**
     * Check if card owner has been set
     *
     * @return bool True if card owner has been set, false if not
     */
    public function hasCardOwner(): bool
    {
        return isset($this->cardOwner);
    }

    /**
     * Get a default card owner value, if any is available
     *
     * @return string|null Default card owner value or null if no default value is available
     */
    public function getDefaultCardOwner(): string|null
    {
        return null;
    }
}
