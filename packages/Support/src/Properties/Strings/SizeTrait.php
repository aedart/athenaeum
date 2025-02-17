<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Size Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\SizeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait SizeTrait
{
    /**
     * The size of something
     *
     * @var string|null
     */
    protected string|null $size = null;

    /**
     * Set size
     *
     * @param string|null $size The size of something
     *
     * @return self
     */
    public function setSize(string|null $size): static
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
     * @return string|null size or null if no size has been set
     */
    public function getSize(): string|null
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
     * @return string|null Default size value or null if no default value is available
     */
    public function getDefaultSize(): string|null
    {
        return null;
    }
}
