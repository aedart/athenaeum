<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Column Aware
 *
 * Component is aware of string "column"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface ColumnAware
{
    /**
     * Set column
     *
     * @param string|null $name Name of column
     *
     * @return self
     */
    public function setColumn(string|null $name): static;

    /**
     * Get column
     *
     * If no column value set, method
     * sets and returns a default column.
     *
     * @see getDefaultColumn()
     *
     * @return string|null column or null if no column has been set
     */
    public function getColumn(): string|null;

    /**
     * Check if column has been set
     *
     * @return bool True if column has been set, false if not
     */
    public function hasColumn(): bool;

    /**
     * Get a default column value, if any is available
     *
     * @return string|null Default column value or null if no default value is available
     */
    public function getDefaultColumn(): string|null;
}
