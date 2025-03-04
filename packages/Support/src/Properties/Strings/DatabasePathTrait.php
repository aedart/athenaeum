<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Database path Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DatabasePathAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DatabasePathTrait
{
    /**
     * Directory path where your databases are located
     *
     * @var string|null
     */
    protected string|null $databasePath = null;

    /**
     * Set database path
     *
     * @param string|null $path Directory path where your databases are located
     *
     * @return self
     */
    public function setDatabasePath(string|null $path): static
    {
        $this->databasePath = $path;

        return $this;
    }

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
    public function getDatabasePath(): string|null
    {
        if (!$this->hasDatabasePath()) {
            $this->setDatabasePath($this->getDefaultDatabasePath());
        }
        return $this->databasePath;
    }

    /**
     * Check if database path has been set
     *
     * @return bool True if database path has been set, false if not
     */
    public function hasDatabasePath(): bool
    {
        return isset($this->databasePath);
    }

    /**
     * Get a default database path value, if any is available
     *
     * @return string|null Default database path value or null if no default value is available
     */
    public function getDefaultDatabasePath(): string|null
    {
        return null;
    }
}
