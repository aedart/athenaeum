<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Index Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\IndexAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait IndexTrait
{
    /**
     * Index
     *
     * @var int|null
     */
    protected int|null $index = null;

    /**
     * Set index
     *
     * @param int|null $index Index
     *
     * @return self
     */
    public function setIndex(int|null $index): static
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
     * @return int|null index or null if no index has been set
     */
    public function getIndex(): int|null
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
     * @return int|null Default index value or null if no default value is available
     */
    public function getDefaultIndex(): int|null
    {
        return null;
    }
}
