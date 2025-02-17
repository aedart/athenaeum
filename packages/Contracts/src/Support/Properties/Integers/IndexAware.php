<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Index Aware
 *
 * Component is aware of int "index"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface IndexAware
{
    /**
     * Set index
     *
     * @param int|null $index Index
     *
     * @return self
     */
    public function setIndex(int|null $index): static;

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
    public function getIndex(): int|null;

    /**
     * Check if index has been set
     *
     * @return bool True if index has been set, false if not
     */
    public function hasIndex(): bool;

    /**
     * Get a default index value, if any is available
     *
     * @return int|null Default index value or null if no default value is available
     */
    public function getDefaultIndex(): int|null;
}
