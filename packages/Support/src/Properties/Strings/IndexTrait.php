<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Index Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\IndexAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait IndexTrait
{
    /**
     * Index
     *
     * @var string|null
     */
    protected string|null $index = null;

    /**
     * Set index
     *
     * @param string|null $index Index
     *
     * @return self
     */
    public function setIndex(string|null $index): static
    {
        $this->index = $index;

        return $this;
    }

    /**
     * Get index
     *
     * If no index value set, method
     * sets and returns a default index.
     *
     * @see getDefaultIndex()
     *
     * @return string|null index or null if no index has been set
     */
    public function getIndex(): string|null
    {
        if (!$this->hasIndex()) {
            $this->setIndex($this->getDefaultIndex());
        }
        return $this->index;
    }

    /**
     * Check if index has been set
     *
     * @return bool True if index has been set, false if not
     */
    public function hasIndex(): bool
    {
        return isset($this->index);
    }

    /**
     * Get a default index value, if any is available
     *
     * @return string|null Default index value or null if no default value is available
     */
    public function getDefaultIndex(): string|null
    {
        return null;
    }
}
