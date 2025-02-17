<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Height Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\HeightAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait HeightTrait
{
    /**
     * Height of something
     *
     * @var int|null
     */
    protected int|null $height = null;

    /**
     * Set height
     *
     * @param int|null $amount Height of something
     *
     * @return self
     */
    public function setHeight(int|null $amount): static
    {
        $this->height = $amount;

        return $this;
    }

    /**
     * Get height
     *
     * If no height value set, method
     * sets and returns a default height.
     *
     * @see getDefaultHeight()
     *
     * @return int|null height or null if no height has been set
     */
    public function getHeight(): int|null
    {
        if (!$this->hasHeight()) {
            $this->setHeight($this->getDefaultHeight());
        }
        return $this->height;
    }

    /**
     * Check if height has been set
     *
     * @return bool True if height has been set, false if not
     */
    public function hasHeight(): bool
    {
        return isset($this->height);
    }

    /**
     * Get a default height value, if any is available
     *
     * @return int|null Default height value or null if no default value is available
     */
    public function getDefaultHeight(): int|null
    {
        return null;
    }
}
