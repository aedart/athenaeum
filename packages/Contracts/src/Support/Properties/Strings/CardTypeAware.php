<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Card type Aware
 *
 * Component is aware of string "card type"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface CardTypeAware
{
    /**
     * Set card type
     *
     * @param string|null $type The type of card, e.g. VISA, MasterCard, Playing Card, Magic Card... etc
     *
     * @return self
     */
    public function setCardType(string|null $type): static;

    /**
     * Get card type
     *
     * If no card type value set, method
     * sets and returns a default card type.
     *
     * @see getDefaultCardType()
     *
     * @return string|null card type or null if no card type has been set
     */
    public function getCardType(): string|null;

    /**
     * Check if card type has been set
     *
     * @return bool True if card type has been set, false if not
     */
    public function hasCardType(): bool;

    /**
     * Get a default card type value, if any is available
     *
     * @return string|null Default card type value or null if no default value is available
     */
    public function getDefaultCardType(): string|null;
}
