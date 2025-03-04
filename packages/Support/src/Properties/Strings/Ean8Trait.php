<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Ean8 Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\Ean8Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait Ean8Trait
{
    /**
     * International Article Number (EAN), 8-digit
     *
     * @var string|null
     */
    protected string|null $ean8 = null;

    /**
     * Set ean8
     *
     * @param string|null $ean8 International Article Number (EAN), 8-digit
     *
     * @return self
     */
    public function setEan8(string|null $ean8): static
    {
        $this->ean8 = $ean8;

        return $this;
    }

    /**
     * Get ean8
     *
     * If no ean8 value set, method
     * sets and returns a default ean8.
     *
     * @see getDefaultEan8()
     *
     * @return string|null ean8 or null if no ean8 has been set
     */
    public function getEan8(): string|null
    {
        if (!$this->hasEan8()) {
            $this->setEan8($this->getDefaultEan8());
        }
        return $this->ean8;
    }

    /**
     * Check if ean8 has been set
     *
     * @return bool True if ean8 has been set, false if not
     */
    public function hasEan8(): bool
    {
        return isset($this->ean8);
    }

    /**
     * Get a default ean8 value, if any is available
     *
     * @return string|null Default ean8 value or null if no default value is available
     */
    public function getDefaultEan8(): string|null
    {
        return null;
    }
}
