<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Database path Aware
 *
 * Component is aware of string "database path"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface DatabasePathAware
{
    /**
     * Set database path
     *
     * @param string|null $path Directory path where your databases are located
     *
     * @return self
     */
    public function setDatabasePath(string|null $path): static;

    /**
     * Get database path
     *
     * If no database path value set, method
     * sets and returns a default database path.
     *
     * @see getDefaultDatabasePath()
     *
     * @return string|null database path or null if no database path has been set
     */
    public function getDatabasePath(): string|null;

    /**
     * Check if database path has been set
     *
     * @return bool True if database path has been set, false if not
     */
    public function hasDatabasePath(): bool;

    /**
     * Get a default database path value, if any is available
     *
     * @return string|null Default database path value or null if no default value is available
     */
    public function getDefaultDatabasePath(): string|null;
}
