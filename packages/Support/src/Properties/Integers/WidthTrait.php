<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Width Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\WidthAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait WidthTrait
{
    /**
     * Width of something
     *
     * @var int|null
     */
    protected int|null $width = null;

    /**
     * Set width
     *
     * @param int|null $amount Width of something
     *
     * @return self
     */
    public function setWidth(int|null $amount): static
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
     * @return int|null width or null if no width has been set
     */
    public function getWidth(): int|null
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
     * @return int|null Default width value or null if no default value is available
     */
    public function getDefaultWidth(): int|null
    {
        return null;
    }
}
