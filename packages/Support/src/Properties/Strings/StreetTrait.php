<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Street Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\StreetAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait StreetTrait
{
    /**
     * Full street address, which might include building or apartment number(s)
     *
     * @var string|null
     */
    protected string|null $street = null;

    /**
     * Set street
     *
     * @param string|null $address Full street address, which might include building or apartment number(s)
     *
     * @return self
     */
    public function setStreet(string|null $address): static
    {
        $this->street = $address;

        return $this;
    }

    /**
     * Get street
     *
     * If no street value set, method
     * sets and returns a default street.
     *
     * @see getDefaultStreet()
     *
     * @return string|null street or null if no street has been set
     */
    public function getStreet(): string|null
    {
        if (!$this->hasStreet()) {
            $this->setStreet($this->getDefaultStreet());
        }
        return $this->street;
    }

    /**
     * Check if street has been set
     *
     * @return bool True if street has been set, false if not
     */
    public function hasStreet(): bool
    {
        return isset($this->street);
    }

    /**
     * Get a default street value, if any is available
     *
     * @return string|null Default street value or null if no default value is available
     */
    public function getDefaultStreet(): string|null
    {
        return null;
    }
}
