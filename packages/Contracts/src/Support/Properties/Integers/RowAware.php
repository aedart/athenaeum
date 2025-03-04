<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Row Aware
 *
 * Component is aware of int "row"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface RowAware
{
    /**
     * Set row
     *
     * @param int|null $identifier A row identifier
     *
     * @return self
     */
    public function setRow(int|null $identifier): static;

    /**
     * Get row
     *
     * If no row value set, method
     * sets and returns a default row.
     *
     * @see getDefaultRow()
     *
     * @return int|null row or null if no row has been set
     */
    public function getRow(): int|null;

    /**
     * Check if row has been set
     *
     * @return bool True if row has been set, false if not
     */
    public function hasRow(): bool;

    /**
     * Get a default row value, if any is available
     *
     * @return int|null Default row value or null if no default value is available
     */
    public function getDefaultRow(): int|null;
}
