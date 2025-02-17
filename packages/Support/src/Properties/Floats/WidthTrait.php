<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Width Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\WidthAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait WidthTrait
{
    /**
     * Width of something
     *
     * @var float|null
     */
    protected float|null $width = null;

    /**
     * Set width
     *
     * @param float|null $amount Width of something
     *
     * @return self
     */
    public function setWidth(float|null $amount): static
    {
        $this->width = $amount;

        return $this;
    }

    /**
     * Get width
     *
     * If no width value set, method
     * sets and returns a default width.
     *
     * @see getDefaultWidth()
     *
     * @return float|null width or null if no width has been set
     */
    public function getWidth(): float|null
    {
        if (!$this->hasWidth()) {
            $this->setWidth($this->getDefaultWidth());
        }
        return $this->width;
    }

    /**
     * Check if width has been set
     *
     * @return bool True if width has been set, false if not
     */
    public function hasWidth(): bool
    {
        return isset($this->width);
    }

    /**
     * Get a default width value, if any is available
     *
     * @return float|null Default width value or null if no default value is available
     */
    public function getDefaultWidth(): float|null
    {
        return null;
    }
}
