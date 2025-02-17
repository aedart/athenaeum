<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Table Aware
 *
 * Component is aware of string "table"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface TableAware
{
    /**
     * Set table
     *
     * @param string|null $name Name of table
     *
     * @return self
     */
    public function setTable(string|null $name): static;

    /**
     * Get table
     *
     * If no table value set, method
     * sets and returns a default table.
     *
     * @see getDefaultTable()
     *
     * @return string|null table or null if no table has been set
     */
    public function getTable(): string|null;

    /**
     * Check if table has been set
     *
     * @return bool True if table has been set, false if not
     */
    public function hasTable(): bool;

    /**
     * Get a default table value, if any is available
     *
     * @return string|null Default table value or null if no default value is available
     */
    public function getDefaultTable(): string|null;
}
