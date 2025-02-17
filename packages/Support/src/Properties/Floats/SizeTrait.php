<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Size Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\SizeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait SizeTrait
{
    /**
     * The size of something
     *
     * @var float|null
     */
    protected float|null $size = null;

    /**
     * Set size
     *
     * @param float|null $size The size of something
     *
     * @return self
     */
    public function setSize(float|null $size): static
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * If no size value set, method
     * sets and returns a default size.
     *
     * @see getDefaultSize()
     *
     * @return float|null size or null if no size has been set
     */
    public function getSize(): float|null
    {
        if (!$this->hasSize()) {
            $this->setSize($this->getDefaultSize());
        }
        return $this->size;
    }

    /**
     * Check if size has been set
     *
     * @return bool True if size has been set, false if not
     */
    public function hasSize(): bool
    {
        return isset($this->size);
    }

    /**
     * Get a default size value, if any is available
     *
     * @return float|null Default size value or null if no default value is available
     */
    public function getDefaultSize(): float|null
    {
        return null;
    }
}
