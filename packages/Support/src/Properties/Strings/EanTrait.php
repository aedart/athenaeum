<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Ean Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\EanAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait EanTrait
{
    /**
     * International Article Number (EAN)
     *
     * @var string|null
     */
    protected string|null $ean = null;

    /**
     * Set ean
     *
     * @param string|null $ean International Article Number (EAN)
     *
     * @return self
     */
    public function setEan(string|null $ean): static
    {
        $this->ean = $ean;

        return $this;
    }

    /**
     * Get ean
     *
     * If no ean value set, method
     * sets and returns a default ean.
     *
     * @see getDefaultEan()
     *
     * @return string|null ean or null if no ean has been set
     */
    public function getEan(): string|null
    {
        if (!$this->hasEan()) {
            $this->setEan($this->getDefaultEan());
        }
        return $this->ean;
    }

    /**
     * Check if ean has been set
     *
     * @return bool True if ean has been set, false if not
     */
    public function hasEan(): bool
    {
        return isset($this->ean);
    }

    /**
     * Get a default ean value, if any is available
     *
     * @return string|null Default ean value or null if no default value is available
     */
    public function getDefaultEan(): string|null
    {
        return null;
    }
}
