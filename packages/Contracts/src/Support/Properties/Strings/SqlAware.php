<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Sql Aware
 *
 * Component is aware of string "sql"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface SqlAware
{
    /**
     * Set sql
     *
     * @param string|null $query A Structured Query Language (SQL) query
     *
     * @return self
     */
    public function setSql(string|null $query): static;

    /**
     * Get sql
     *
     * If no sql value set, method
     * sets and returns a default sql.
     *
     * @see getDefaultSql()
     *
     * @return string|null sql or null if no sql has been set
     */
    public function getSql(): string|null;

    /**
     * Check if sql has been set
     *
     * @return bool True if sql has been set, false if not
     */
    public function hasSql(): bool;

    /**
     * Get a default sql value, if any is available
     *
     * @return string|null Default sql value or null if no default value is available
     */
    public function getDefaultSql(): string|null;
}
