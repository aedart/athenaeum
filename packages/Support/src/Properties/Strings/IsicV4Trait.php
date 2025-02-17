<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Isic v4 Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\IsicV4Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait IsicV4Trait
{
    /**
     * International Standard of Industrial Classification of All Economic Activities (ISIC), revision 4 code
     *
     * @var string|null
     */
    protected string|null $isicV4 = null;

    /**
     * Set isic v4
     *
     * @param string|null $code International Standard of Industrial Classification of All Economic Activities (ISIC), revision 4 code
     *
     * @return self
     */
    public function setIsicV4(string|null $code): static
    {
        $this->isicV4 = $code;

        return $this;
    }

    /**
     * Get isic v4
     *
     * If no isic v4 value set, method
     * sets and returns a default isic v4.
     *
     * @see getDefaultIsicV4()
     *
     * @return string|null isic v4 or null if no isic v4 has been set
     */
    public function getIsicV4(): string|null
    {
        if (!$this->hasIsicV4()) {
            $this->setIsicV4($this->getDefaultIsicV4());
        }
        return $this->isicV4;
    }

    /**
     * Check if isic v4 has been set
     *
     * @return bool True if isic v4 has been set, false if not
     */
    public function hasIsicV4(): bool
    {
        return isset($this->isicV4);
    }

    /**
     * Get a default isic v4 value, if any is available
     *
     * @return string|null Default isic v4 value or null if no default value is available
     */
    public function getDefaultIsicV4(): string|null
    {
        return null;
    }
}
