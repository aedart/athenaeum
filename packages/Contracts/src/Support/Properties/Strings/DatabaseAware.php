<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Database Aware
 *
 * Component is aware of string "database"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface DatabaseAware
{
    /**
     * Set database
     *
     * @param string|null $name Name of database
     *
     * @return self
     */
    public function setDatabase(string|null $name): static;

    /**
     * Get database
     *
     * If no database value set, method
     * sets and returns a default database.
     *
     * @see getDefaultDatabase()
     *
     * @return string|null database or null if no database has been set
     */
    public function getDatabase(): string|null;

    /**
     * Check if database has been set
     *
     * @return bool True if database has been set, false if not
     */
    public function hasDatabase(): bool;

    /**
     * Get a default database value, if any is available
     *
     * @return string|null Default database value or null if no default value is available
     */
    public function getDefaultDatabase(): string|null;
}
